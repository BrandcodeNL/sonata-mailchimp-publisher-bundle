<?php
/*
 * This file is part of the BrandcodeNL SonataMailchimpPublisherBundle.
 * (c) BrandcodeNL
 */
namespace BrandcodeNL\SonataMailchimpPublisherBundle\Provider;


/**
 * @author Jeroen de Kok <jeroen.dekok@aveq.nl>
 */
interface BatchListProviderInterface
{
   
    /**
     * Return the lists for publishing
     * @param $object object that gets published 
     */
    public function getLists($objects);

    /**
     * Return the segmentation for the given list
     * @param ListInterface $list 
     * @param $object object that gets published 
     */
    public function getSegments($lists, $objects);

    public function getListById($id);
}