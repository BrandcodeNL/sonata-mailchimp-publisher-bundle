<?php
/*
 * This file is part of the BrandcodeNL SonataMailchimpPublisherBundle.
 * (c) BrandcodeNL
 */
namespace BrandcodeNL\SonataMailchimpPublisherBundle\Channel;

use DrewM\MailChimp\MailChimp;
use BrandcodeNL\SonataPublisherBundle\Entity\PublishResponce;
use BrandcodeNL\SonataPublisherBundle\Channel\ChannelInterface;
use BrandcodeNL\SonataMailchimpPublisherBundle\Model\ListInterface;
use BrandcodeNL\SonataMailchimpPublisherBundle\Formatter\FormatterInterface;
use BrandcodeNL\SonataMailchimpPublisherBundle\Provider\ListProviderInterface;
use BrandcodeNL\SonataMailchimpPublisherBundle\Provider\SettingsProviderInterface;

/**
 * @author Jeroen de Kok <jeroen.dekok@aveq.nl>
 */
class MailchimpChannel implements ChannelInterface
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
     * MailChimp settings provider
     * @var SettingsProviderInterface
     */
    protected $settingsProvider;

     /**
     * Object HTML formatter
     * @var FormatterInterface
     */
    protected $formatter;

    /**
     * @param MailChimp $mailchimp
     */
    public function __construct(MailChimp $mailchimp, ListProviderInterface $listProvider, SettingsProviderInterface $settingsProvider, FormatterInterface $formatter)
    {
        $this->mailchimp = $mailchimp;
        $this->listProvider = $listProvider;
        $this->settingsProvider = $settingsProvider;
        $this->formatter = $formatter;
    }


    /**
     * Publish object to Mailchimp
     * @param $object
     * TODO List can be on diffrent API key
     */
    public function publish($object)
    {
        $this->settingsProvider->setObject($object);
        $results = array();
        //Loop through all the lists provided by the list provider
        foreach($this->listProvider->getLists($object) as $list) 
        {          
            if(!empty($list->getApiKey()))
            {
                $this->reinitializeMailchimp($list->getApiKey());
            }
            $campaign = $this->createCampaign($list);
            $campaignId = $campaign['id'] ? $campaign['id'] : null;

            if($campaignId)
            {
                $results[] = array_merge($campaign, $this->insertContentInCampaign($campaignId, $list, $object));
            }
        }     
        
        return $this->generateSuccessResponce($results);
        
    }

    /**
     * Create a new campaign
     */
    protected function createCampaign($list)
    {
        if(!$list instanceof ListInterface)
        {
            Throw new \Exception(get_class($list)." is not an instance of ".ListInterface::class);
        }

        $this->settingsProvider->setList($list);
       
        $result = $this->mailchimp->post("campaigns",
            array(
                "recipients" => array(
                    'list_id' => $list->getListId()
                ),
                'type' => 'regular',
                'settings' =>
                    array_merge(
                        array(
                            'subject_line' => $this->settingsProvider->getSubject(),
                            'template_id' => $this->settingsProvider->getTemplateId(),
                        ),
                        $this->settingsProvider->getFrom()
                    )   
            )
        );

        if(!empty($result['errors']))
        {
            //handle errors ? 
            Throw new \Exception(json_encode($result['errors']));
        }

        return $result;
    }

    /**
     * Update an existing campaign and add content
     */
    protected function insertContentInCampaign($campaignId, $list, $object)
    {
         //proceed with adding content
         $result = $this->mailchimp->put("campaigns/{$campaignId}/content",
            array(
                "template" => array(
                    'id' => $this->settingsProvider->getTemplateId(),
                    'sections' => array(
                        'content' => $this->formatter->generateHTML($object, $list)
                    )
                )
            )
        );

        if(!empty($result['errors']))
        {
            //handle errors ? 
            Throw new \Exception(json_encode($result['errors']));
        }

        return $result;
  
    }

    private function reinitializeMailchimp($apiKey)
    {
        $this->mailchimp = new Mailchimp($apiKey);
    }

    public function generateSuccessResponce($result)
    {
        
        return  new PublishResponce("success", count($result), $result, strval($this));

    }
    
    public function __toString()
    {
        return "sonata.publish.mailchimp";
    }
}