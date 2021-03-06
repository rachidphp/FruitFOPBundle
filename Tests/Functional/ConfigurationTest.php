<?php

namespace Fruit\FOPBundle\Tests\Functional;

use Symfony\Component\Filesystem\Filesystem;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    private $cacheDir;
    private $kernel;

    public function setUp()
    {
        $this->cacheDir = __DIR__.'/Resources/cache';
        if (file_exists($this->cacheDir)) {
            $filesystem = new Filesystem();
            $filesystem->remove($this->cacheDir);
        }

        mkdir($this->cacheDir, 0777, true);

        $this->kernel = new TestKernel('test', false);
        $this->kernel->boot();
    }

    public function tearDown()
    {
        if (file_exists($this->cacheDir)) {
            $filesystem = new Filesystem();
            $filesystem->remove($this->cacheDir);
        }
    }

    public function testSetFileSystems()
    {
        $container = $this->kernel->getContainer();

        $this->assertSame($container->get('pdf_storage_filesystem'), $container->get('favouritefruit.fop.target_filesystem'));
        $this->assertSame($container->get('temp_filesystem'), $container->get('favouritefruit.fop.temp_filesystem'));
        $this->assertNotNull($container->getParameter('favouritefruit.fop.temp_directory'));
    }

    public function testDefaultSettings()
    {
        $container = $this->kernel->getContainer();

        $this->assertSame('FruitFOP\Entity\Source', $container->getParameter('favouritefruit.fop.source.class'));
        $this->assertInstanceOf('FruitFOP\Handler\LocalProcessor', $container->get('favouritefruit.fop.fop_processor'));
        $this->assertInstanceOf('Fruit\FOPBundle\Manager\FOPManager', $container->get('favouritefruit.fop.fop_manager'));
        $this->assertInstanceOf('Fruit\FOPBundle\Manager\FOPManager', $container->get('fop_manager'));
    }
}
