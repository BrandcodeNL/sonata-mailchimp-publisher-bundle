<?php

namespace BrandcodeNL\SonataMailchimpPublisherBundle\Formatter;

use BrandcodeNL\SonataMailchimpPublisherBundle\Model\ListInterface;

interface FormatterInterface
{
    
    public function generateHTML($object, ListInterface $list);
}
