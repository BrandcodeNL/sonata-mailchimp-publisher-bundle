<?php

namespace BrandcodeNL\SonataMailchimpPublisherBundle\Channel;

use DrewM\MailChimp\MailChimp;
use BrandcodeNL\SonataPublisherBundle\Channel\ChannelInterface;
use BrandcodeNL\SonataMailchimpPublisherBundle\Model\ListInterface;
use BrandcodeNL\SonataMailchimpPublisherBundle\Provider\ListProviderInterface;

class MailchimpChannel implements ChannelInterface
{
        
    /**
     * MailChimp Object
     * @var MailChimp
     */
    protected $mailchimp;

    /**
     * @param MailChimp $mailchimp
     */
    public function __construct(MailChimp $mailchimp, ListProviderInterface $listProvider)
    {
        $this->mailchimp = $mailchimp;
        $this->listProvider = $listProvider;
    }


    /**
     * Publish object to Mailchimp
     * @param $object
     * TODO dynamic subject
     * TODO List can be on diffrent API key
     * TODO insert the object with a configured template ? template provider ? 
     * TODO dynamic reply to & from
     */
    public function publish($object)
    {
        //Loop through all the lists provided by the list provider
        foreach($this->listProvider->getLists($object) as $list) 
        {
            if(!$list instanceof ListInterface)
            {
                Throw new \Exception(get_class($list)." is not an instance of ".ListInterface::class);
            }
           
            // $result = $this->mailchimp->post("campaigns",
            //     array(
            //         "recipients" => array(
            //             'list_id' => $list->getListId()
            //         ),
            //         'type' => 'regular',
            //         'settings' => array(
            //             'subject_line' => "Subject",
            //             'reply_to' => 'pontsteiger@aveqimedia.nl',
            //             'from_name' => 'ponsteiger'
            //         )
            //     )
            // );
        }
        
        
        dump($result);
        exit;
    }
}