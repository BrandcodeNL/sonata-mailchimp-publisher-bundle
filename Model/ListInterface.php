<?php

namespace BrandcodeNL\SonataMailchimpPublisherBundle\Model;

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

}