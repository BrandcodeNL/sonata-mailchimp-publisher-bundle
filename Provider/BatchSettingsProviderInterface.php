<?php
/*
 * This file is part of the BrandcodeNL SonataMailchimpPublisherBundle.
 * (c) BrandcodeNL
 */
namespace BrandcodeNL\SonataMailchimpPublisherBundle\Provider;

use AppBundle\Entity\Mailchimp\MailchimpList;
use BrandcodeNL\SonataMailchimpPublisherBundle\Model\ListInterface;

/**
 * @author Jeroen de Kok <jeroen.dekok@aveq.nl>
 */
interface BatchSettingsProviderInterface
{   
   
    /**
     * @param $object the object that gets published 
     */
    public function setObjects($objects);

    /**
     * Get the from email for the campaign
     */
    public function getFrom(ListInterface $list);

    /**
     * Get the possible templates to use for this campaign
     */
    public function getTemplates();


    public function getTemplateIdById($id);
}