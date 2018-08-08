<?php
/*
 * This file is part of the BrandcodeNL SonataMailchimpPublisherBundle.
 * (c) BrandcodeNL
 */
namespace BrandcodeNL\SonataMailchimpPublisherBundle\Model;

/**
 * @author Jeroen de Kok <jeroen.dekok@aveq.nl>
 */
interface ListInterface
{
    
    /**
     * Get the Mailchimp compatible list id
     */
    public function getListId();

    /**
     * (optional) Get apikey for this specific list if empty the main api key will be used
     */
    public function getApiKey();

    public function __toString();

}