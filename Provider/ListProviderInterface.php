<?php

namespace BrandcodeNL\SonataMailchimpPublisherBundle\Provider;

interface ListProviderInterface
{
   
    /**
     * Return the lists for publishing
     * @param $object object that gets published 
     */
    public function getLists($object);

}