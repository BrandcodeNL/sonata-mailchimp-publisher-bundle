<?php
/*
 * This file is part of the BrandcodeNL SonataMailchimpPublisherBundle.
 * (c) BrandcodeNL
 */
namespace BrandcodeNL\SonataMailchimpPublisherBundle\Provider;

use BrandcodeNL\SonataMailchimpPublisherBundle\Model\ListInterface;
use BrandcodeNL\SonataMailchimpPublisherBundle\Model\MailchimpList;

/**
 * @author Jeroen de Kok <jeroen.dekok@aveq.nl>
 */
class BatchSettingsProvider implements BatchSettingsProviderInterface  
{
   
    
    private $objects;    
  
    /**
     * {@inheritdoc}
     */
    public function setObjects($objects)
    {
        $this->objects = $objects;
    }


    /**
     * {@inheritdoc}
     * Get the template ID from the config
     */
    public function getTemplates()
    {
        
    }    

    public function getTemplateIdById($id)
    {
        
    }

    public function getFrom(ListInterface $list)
    {

    }

    public function __toString()
    {
 
    }

}