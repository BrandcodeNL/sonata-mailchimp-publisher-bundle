<?php
/*
 * This file is part of the BrandcodeNL SonataMailchimpPublisherBundle.
 * (c) BrandcodeNL
 */
namespace BrandcodeNL\SonataMailchimpPublisherBundle\Formatter;

use Twig_Environment as Environment;
use BrandcodeNL\SonataMailchimpPublisherBundle\Model\ListInterface;

/**
 * @author Jeroen de Kok <jeroen.dekok@aveq.nl>
 */
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
    public function generateHTML($objects, ListInterface $list)
    {
        //find correct format template and generate the HTML
        $template = $this->configLists[$list->getListId()]['format'];
        $html = $this->twig->render($template, array('list' => $list, 'objects' => $objects));

        return $html;
    }
    
}