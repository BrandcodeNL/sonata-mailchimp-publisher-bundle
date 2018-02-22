<?php
/*
 * This file is part of the BrandcodeNL SonataMailchimpPublisherBundle.
 * (c) BrandcodeNL
 */
namespace BrandcodeNL\SonataMailchimpPublisherBundle\Provider;

use BrandcodeNL\SonataMailchimpPublisherBundle\Model\MailchimpList;
use BrandcodeNL\SonataMailchimpPublisherBundle\Model\ListInterface;

/**
 * @author Jeroen de Kok <jeroen.dekok@aveq.nl>
 */
class ListProvider implements ListProviderInterface
{
   
    /**
     * Return the lists for publishing from the configuration file
     * @param $object object that gets published 
     * @return Array<MailchimpList>
     * TODO Read configuration file for list(s) to publish
     */
    public function getLists($object)
    {
        $list = new MailchimpList();
        $list->setId('???');
        $list->setApiKey();
        return array($list);
    }

    /**
     * {@inheritdoc}
     */
    public function getSegment(ListInterface $list, $object)
    {
        return null;
    }

}