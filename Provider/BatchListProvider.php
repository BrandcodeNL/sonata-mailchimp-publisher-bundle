<?php
/*
 * This file is part of the BrandcodeNL SonataMailchimpPublisherBundle.
 * (c) BrandcodeNL
 */
namespace BrandcodeNL\SonataMailchimpPublisherBundle\Provider;

/**
 * @author Jeroen de Kok <jeroen.dekok@aveq.nl>
 */
class BatchListProvider implements BatchListProviderInterface
{
   
    /**
     * Return the lists available for publishing from the configuration file
     * @param $object object that gets published 
     * @return Array<MailchimpList>
     * TODO Read configuration file for list(s) to publish
     */
    public function getLists($objects)
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function getSegments($lists, $objects)
    {
        return null;
    }


    /**
     * {@inheritdoc}
     */
    public function getListById($id)
    {
        return null; 
    }


}