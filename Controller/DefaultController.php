<?php

namespace BrandcodeNL\SonataMailchimpPublisherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BrandcodeNLSonataMailchimpPublisherBundle:Default:index.html.twig');
    }
}
