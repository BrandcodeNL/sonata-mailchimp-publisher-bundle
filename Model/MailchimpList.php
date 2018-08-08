<?php
/*
 * This file is part of the BrandcodeNL SonataMailchimpPublisherBundle.
 * (c) BrandcodeNL
 */
namespace BrandcodeNL\SonataMailchimpPublisherBundle\Model;

/**
 * @author Jeroen de Kok <jeroen.dekok@aveq.nl>
 */
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

    public function __toString()
    {
        return $this->listId;
    }

}