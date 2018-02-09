<?php

namespace BrandcodeNL\SonataMailchimpPublisherBundle\Formatter;

use Twig_Environment as Environment;
use BrandcodeNL\SonataMailchimpPublisherBundle\Model\ListInterface;

class TwigFormatter implements FormatterInterface
{
    
    private $twig; 
    private $configLists; 

    public function __construct(Environment $twig, $configLists)
    {
        $this->twig         = $twig;    
        $this->configLists  = $configLists;  
        
    }

    /**
     * {@inheritdoc}
     */
    public function generateHTML($object, ListInterface $list)
    {
        //find correct format template and generate the HTML
        $template = $this->configLists[$list->getListId()]['format'];
        $html = $this->twig->render($template, array('list' => $list, 'object' => $object));

        return $html;

    }
}