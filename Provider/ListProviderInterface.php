<?php
/*
 * This file is part of the BrandcodeNL SonataMailchimpPublisherBundle.
 * (c) BrandcodeNL
 */
namespace BrandcodeNL\SonataMailchimpPublisherBundle\Provider;

use BrandcodeNL\SonataMailchimpPublisherBundle\Model\ListInterface;

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

    /**
     * Return the segmentation for the given list
     * @param ListInterface $list
     * @param $object object that gets published
     * @return array|null
     */
    public function getSegments(ListInterface $list, $object);
}
