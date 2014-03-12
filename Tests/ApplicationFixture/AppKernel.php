<?php

namespace Jonlil\CKFinderBundle\Tests\ApplicationFixture;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpFoundation\Request;

class AppKernel extends Kernel
{

    public function registerBundles()
    {
        return array(
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new \Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new \Jonlil\CKFinderBundle\JonlilCKFinderBundle('IvoryCKEditorBundle'),
            );
    }


    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config.yml');
    }


    protected function initializeContainer() {
        parent::initializeContainer();
        $this->getContainer()->enterScope('request');
        $this->getContainer()->set('request', new Request(), 'request');
    }
}