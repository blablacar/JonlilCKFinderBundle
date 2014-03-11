<?php

namespace Jonlil\CKFinderBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Jonlil\CKFinderBundle\Tests\ApplicationFixture\AppKernel;

class BundleIntegrationTest extends WebTestCase
{

    protected static function createKernel(array $options = array())
    {
        return new AppKernel('test', true);
    }

    /**
     * @test
     */
    public function itRegistersTheCkfinderFormType()
    {
        $client = self::createClient();

        $container = $client->getKernel()->getContainer();

        $this->assertTrue($container->has('form.type.ckfinder'));
    }
}