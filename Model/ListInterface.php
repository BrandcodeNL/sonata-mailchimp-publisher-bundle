<?php

namespace BrandcodeNL\SonataMailchimpPublisherBundle\Model;

interface ListInterface
{
    
    /**
     * Get the Mailchimp compatible list id
     */
    public function getListId();

}