<?php
/*
 * This file is part of the BrandcodeNL SonataMailchimpPublisherBundle.
 * (c) BrandcodeNL
 */
namespace BrandcodeNL\SonataMailchimpPublisherBundle\Provider;

/**
 * @author Jeroen de Kok <jeroen.dekok@aveq.nl>
 */
interface ListProviderInterface
{
   
    /**
     * Return the lists for publishing
     * @param $object object that gets published 
     */
    public function getLists($object);

}