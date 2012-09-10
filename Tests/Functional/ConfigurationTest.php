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

        $this->assertSame($container->get('pdf_storage_filesystem'), $container->get('fruit.fop.target_filesystem'));
        $this->assertSame($container->get('temp_filesystem'), $container->get('fruit.fop.temp_filesystem'));
    }

}
