<?php

namespace BrandcodeNL\SonataMailchimpPublisherBundle\Model;

class MailchimpList implements ListInterface
{
    
    private $listId;

    /**
     * Get the Mailchimp compatible list id
     */
    public function getListId()
    {
        return $this->listId;
    }

    /**
     * Set the mailchimp compatible id
     */
    public function setListId($listId)
    {
        $this->listId = $listId;
    }

}