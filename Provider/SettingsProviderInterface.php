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
interface SettingsProviderInterface
{
   
    /**
     * @param ListInterface $list the mailchimp list    
     */
    public function setList(ListInterface $list);

    /**
     * @param $object the object that gets published 
     */
    public function setObject($object);

    /**
     * Get the subject for the campaign
     */
    public function getSubject();

    /**
     * Get the from name and email for the campaign
     */
    public function getFrom();

    /**
     * Get the template ID for this campaign
     */
    public function getTemplateId();
}