<?php
/*
 * This file is part of the BrandcodeNL SonataMailchimpPublisherBundle.
 * (c) BrandcodeNL
 */
namespace BrandcodeNL\SonataMailchimpPublisherBundle\Channel;

use BrandcodeNL\SonataMailchimpPublisherBundle\Event\MailchimpCampaignEvent;
use BrandcodeNL\SonataMailchimpPublisherBundle\Event\MailchimpCampaignEvents;
use DrewM\MailChimp\MailChimp;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use BrandcodeNL\SonataPublisherBundle\Entity\PublishResponce;
use BrandcodeNL\SonataPublisherBundle\Channel\ChannelInterface;
use BrandcodeNL\SonataMailchimpPublisherBundle\Model\ListInterface;
use BrandcodeNL\SonataPublisherBundle\Channel\BatchChannelInterface;
use BrandcodeNL\SonataMailchimpPublisherBundle\Formatter\FormatterInterface;
use BrandcodeNL\SonataMailchimpPublisherBundle\Provider\ListProviderInterface;
use BrandcodeNL\SonataMailchimpPublisherBundle\Provider\ContentProviderInterface;
use BrandcodeNL\SonataMailchimpPublisherBundle\Provider\SettingsProviderInterface;
use BrandcodeNL\SonataMailchimpPublisherBundle\Provider\BatchListProviderInterface;
use BrandcodeNL\SonataMailchimpPublisherBundle\Provider\BatchSettingsProviderInterface;

/**
 * @author Jeroen de Kok <jeroen.dekok@aveq.nl>
 */
class MailchimpChannel implements ChannelInterface, BatchChannelInterface
{

    /**
     * MailChimp Object
     * @var MailChimp
     */
    protected $mailchimp;

    /**
     * MailChimp List provider
     * @var ListProviderInterface
     */
    protected $listProvider;

    /**
     * MailChimp Batch List provider
     * @var BatchListProviderInterface
     */
    protected $batchListProvider;

    /**
     * MailChimp settings provider
     * @var SettingsProviderInterface
     */
    protected $settingsProvider;

    /**
     * MailChimp batch settings provider
     * @var BatchSettingsProviderInterface
     */
    protected $batchSettingsProvider;

    /**
    * Object HTML formatter
    * @var FormatterInterface
    */
    protected $formatter;

    protected $requestStack;

    protected $contentProvider;
    protected $dispatcher;

    /**
     * @param MailChimp $mailchimp
     */
    public function __construct(
            MailChimp $mailchimp,
            ListProviderInterface $listProvider,
            BatchListProviderInterface $batchListProvider,
            SettingsProviderInterface $settingsProvider,
            BatchSettingsProviderInterface $batchSettingsProvider,
            FormatterInterface $formatter,
            ContentProviderInterface $contentProvider,
            RequestStack $requestStack,
            EventDispatcherInterface $dispatcher
    ) {
        $this->mailchimp = $mailchimp;
        $this->listProvider = $listProvider;
        $this->batchListProvider = $batchListProvider;
        $this->settingsProvider = $settingsProvider;
        $this->batchSettingsProvider = $batchSettingsProvider;
        $this->formatter = $formatter;
        $this->contentProvider = $contentProvider;
        $this->requestStack = $requestStack;
        $this->dispatcher = $dispatcher;
    }


    /**
     * Undocumented function
     *
     * @param [type] $objects
     * @return void
     */
    public function batchPrepare($objects)
    {
        $this->batchSettingsProvider->setObjects($objects);
        return array(
            'template' => 'BrandcodeNLSonataMailchimpPublisherBundle:CRUD:batch_prepare.html.twig',
            'parameters' => array(
                'lists' => $this->batchListProvider->getLists($objects),
                #'templates' => $this->batchSettingsProvider->getTemplates()
            )
        );
    }

    /**
     * Publish object to Mailchimp
     * @param $object
     * TODO better error handling
     */
    public function publish($object)
    {

        $this->settingsProvider->setObject($object);
        $results = array();
        //Loop through all the lists provided by the list provider
        foreach ($this->listProvider->getLists($object) as $list) {
            if (!empty($list->getApiKey())) {
                $this->reinitializeMailchimp($list->getApiKey());
            }
            $campaign = $this->createCampaign($list, $object);

            $campaignId = isset($campaign['id']) ? $campaign['id'] : null;

            if ($campaignId) {
                $campaignResult = $this->insertContentInCampaign($campaignId, $list, array($object), $this->settingsProvider->getTemplateId());
                if (!isset($campaignResult['errors']) &&  $this->settingsProvider->getScheduleDateTime() != null) {
                    //schedule campaign if date is provided by the settingsProvider
                    $this->scheduleCampaign($campaignId, $this->settingsProvider->getScheduleDateTime());
                }
                $results[] = array_merge($campaign, $campaignResult);
            } else {
                $results = $campaign;
            }
        }

        return $this->generateSuccessResponce($results);
    }

    public function publishBatch($objects)
    {

        $this->batchSettingsProvider->setObjects($objects);

        $data = $this->requestStack->getCurrentRequest()->get('mailchimp');

        $list = $this->batchListProvider->getListById($data['list']);

        if (!empty($list->getApiKey())) {
            $this->reinitializeMailchimp($list->getApiKey());
        }

        $this->settingsProvider->setList($list);
        $templateId = $this->settingsProvider->getTemplateId();

        $recipients = array(
            'list_id' => $list->getListId(),
        );

        $from = $this->batchSettingsProvider->getFrom($list);
        //retrieve posible segment from list provider
        $segment = $this->batchListProvider->getSegments($list, $objects);
        if (!empty($segment)) {
            $recipients['segment_opts'] = $segment;
        }

        $campaign =  $this->createMailchimpCampaign($recipients, $data['subject'], $templateId, $from, $data['preview']);
        $campaignId = isset($campaign['id']) ? $campaign['id'] : null;

        if ($campaignId) {
            $campaignResult = $this->insertContentInCampaign($campaignId, $list, $objects, $templateId);

            $results[] = array_merge($campaign, $campaignResult);
        } else {
            $results = $campaign;
        }

        return $this->generateSuccessResponce($results);
    }

    /**
     * Create a new campaign
     */
    protected function createCampaign($list, $object)
    {
        if (!$list instanceof ListInterface) {
            throw new \Exception(get_class($list)." is not an instance of ".ListInterface::class);
        }

        $this->settingsProvider->setList($list);

        $recipients = array(
            'list_id' => $list->getListId(),
        );

        //retrieve posible segment from list provider
        $segment = $this->listProvider->getSegment($list, $object);
        if (!empty($segment)) {
            $recipients['segment_opts'] = $segment;
        }

        return $this->createMailchimpCampaign($recipients, $this->settingsProvider->getSubject(), $this->settingsProvider->getTemplateId(), $this->settingsProvider->getFrom(), $this->settingsProvider->getPreview());

    }


    private function createMailchimpCampaign($recipients, $subject, $template, $from, $preview = "")
    {

        $result = $this->mailchimp->post(

            "campaigns",
            array(
                "recipients" => $recipients,
                'type' => 'regular',
                'settings' =>
                    array_merge(
                        array(
                            'subject_line' => $subject,
                            'template_id' => $template,
                            'preview_text' => $preview
                        ),
                        $from
                    ),
            )
        );

        return $result;
    }

    /**
     * Update an existing campaign and add content
     * TODO dont hardcode the section ID Here ?
     * TODO Support multiple sections ?
     */
    protected function insertContentInCampaign($campaignId, $list, $objects, $templateId)
    {
        $content = $this->contentProvider->provideContent($list, $objects);

        //proceed with adding content
        $result = $this->mailchimp->put(
             "campaigns/{$campaignId}/content",
            array(
                "template" => array(
                    'id' => $templateId,
                    'sections' => $content
                )
            )
        );

        if (!empty($result['errors'])) {
            //handle errors ?
            throw new \Exception(json_encode($result['errors']));
        }

        return $result;
    }


    /**
     * Schedule a campaign
     * TODO error handling ?
     */
    protected function scheduleCampaign($campaignId, $datetime)
    {
        //convert to UTC
        $datetime->setTimezone(new \DateTimeZone("UTC"));
        $result = $this->mailchimp->post(

            "campaigns/{$campaignId}/actions/schedule",
            array(
                "schedule_time" => $datetime->format('Y-m-d H:i:s e')
            )
        );
    }

    private function reinitializeMailchimp($apiKey)
    {
        $this->mailchimp = new Mailchimp($apiKey);
    }

    public function generateSuccessResponce($result)
    {
        if (!empty($result['errors'])) {
            return  new PublishResponce("error", count($result), $result['errors'], strval($this));
        }
        $mailchimpCampaignEvent = new MailchimpCampaignEvent($result);
        $this->dispatcher->dispatch(MailchimpCampaignEvents::CAMPAIGN_CREATED, $mailchimpCampaignEvent);
        return  new PublishResponce("success", count($result), $result, strval($this));
    }

    public function __toString()
    {
        return "sonata.publish.mailchimp";
    }
}
