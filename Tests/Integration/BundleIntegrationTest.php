<?php

namespace Jonlil\CKFinderBundle\Tests\Integration;

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


    /**
     * @test
     */
    public function itAllowsTheCreationOfCkfinderForms()
    {
        $client = self::createClient();

        $crawler = $client->request('GET', '/test/form');

        $this->assertEquals(1, $crawler->filter('textarea#form_content')->count());
    }

    /**
     * @test
     */
    public function itShowsTheProperAssetPaths()
    {
        $client = self::createClient();

        $crawler = $client->request('GET', '/test/form');

        $this->assertEquals(1, $crawler->filter('script[type="text/javascript"][src="/bundles/ivoryckeditor/ckeditor.js"]')->count());
        $this->assertEquals(1, $crawler->filter('iframe[src="/bundles/ivoryckeditor/"]')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("var CKEDITOR_BASEPATH = \'/bundles/ivoryckeditor/\';")')->count());
        
    }

}
