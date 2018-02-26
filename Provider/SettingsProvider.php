<?php
/*
 * This file is part of the BrandcodeNL SonataMailchimpPublisherBundle.
 * (c) BrandcodeNL
 */
namespace BrandcodeNL\SonataMailchimpPublisherBundle\Provider;

use BrandcodeNL\SonataMailchimpPublisherBundle\Model\ListInterface;

/**
 * @author Jeroen de Kok <jeroen.dekok@aveq.nl>
 */
class SettingsProvider implements SettingsProviderInterface  
{
   
    private $list;
    private $object;

    private $configLists; 

    public function __construct($configLists)
    {
        $this->configLists = $configLists;       
    }

    /**
     * {@inheritdoc}
     */
    public function setList(ListInterface $list)
    {
        $this->list = $list;
    }

    /**
     * {@inheritdoc}
     */
    public function setObject($object)
    {
        $this->object = $object;
    }

    /**
     * {@inheritdoc}
     * use the toString method of the object to get the subject
     */
    public function getSubject()
    {
        return strval($this->object);
    }

    /**
     * {@inheritdoc}
     * Return the from email and name from the config
     */
    public function getFrom()
    {      
        $list = $this->configLists[$this->list->getListId()];
        //use the configured values for the current list in the config       
        return array(
            'from_name'  =>  ($list['fromName'] ? $list['fromName'] : ''),
            'reply_to' =>  ($list['fromEmail'] ? $list['fromEmail'] : ''),
        );
         
    }

    /**
     * {@inheritdoc}
     * Get the template ID from the config
     */
    public function getTemplateId()
    {
        return $this->configLists[$this->list->getListId()]['template'];
    }
    
    /**
     * {@inheritdoc}
     * Return null so the campaign is only created
     * TODO check if the campaign is allowed to be send from the config then return current dateTime
     */
    public function getScheduleDateTime()
    {
        return null;
    }
       
    

}