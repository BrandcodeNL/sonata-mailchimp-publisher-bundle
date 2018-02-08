<?php

namespace BrandcodeNL\SonataMailchimpPublisherBundle\Provider;

use BrandcodeNL\SonataMailchimpPublisherBundle\Model\MailchimpList;

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
        $list->setId('6cf7ae4e71');
        return array($list);
    }

}