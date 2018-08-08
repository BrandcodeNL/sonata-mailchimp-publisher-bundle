<?php
/*
 * This file is part of the BrandcodeNL SonataMailchimpPublisherBundle.
 * (c) BrandcodeNL
 */
namespace BrandcodeNL\SonataMailchimpPublisherBundle\Formatter;

use BrandcodeNL\SonataMailchimpPublisherBundle\Model\ListInterface;

/**
 * @author Jeroen de Kok <jeroen.dekok@aveq.nl>
 */
interface FormatterInterface
{
    
    public function generateHTML($objects, ListInterface $list);
}
