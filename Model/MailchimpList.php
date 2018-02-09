<?php

namespace BrandcodeNL\SonataMailchimpPublisherBundle\Model;

class MailchimpList implements ListInterface
{
    
    private $listId;
    private $apiKey;

    /**
     * {@inheritdoc}
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

    /**
     * {@inheritdoc}
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set the optional api key
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

}