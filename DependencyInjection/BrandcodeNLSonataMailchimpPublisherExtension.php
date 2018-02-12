<?php
/*
 * This file is part of the BrandcodeNL SonataMailchimpPublisherBundle.
 * (c) BrandcodeNL
 */
namespace BrandcodeNL\SonataMailchimpPublisherBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Jeroen de Kok <jeroen.dekok@aveq.nl>
 * This is the class that loads and manages your bundle configuration. * 
 */
class BrandcodeNLSonataMailchimpPublisherExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);       
       
        $container->setParameter('brandcode_nl_sonata_mailchimp_publisher.api_key', isset($config['api_key']) ? $config['api_key'] : null);
        $container->setParameter('brandcode_nl_sonata_mailchimp_publisher.lists', $config['lists']);

    }
}
