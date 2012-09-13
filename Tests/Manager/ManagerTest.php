<?php

use Fruit\FOPBundle\Manager\FOPManager;
use FruitFOP\Entity\Source;
use FruitFOP\Handler\LocalProcessor;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\InMemory;
use Gaufrette\Adapter\Local;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateFromData()
    {
        $mgr = $this->getManager();
        $data = new DataClass('alpha', new Beta(), array('delta' => 'gamma'));
        $document = $mgr->generateFromData($data);

        $this->assertInstanceOf('Gaufrette\File', $document);
        $this->assertTrue($this->isPdf($document->getContent()));
    }

    protected function getManager()
    {
        $tempFolder = __DIR__ . '/../Resources/temp';
        if (!file_exists($tempFolder)) {
            mkdir($tempFolder, 0777, true);
        }
        $processor = new LocalProcessor($tempFolder);

        $tempFileSystem = new Filesystem(new Local($tempFolder));
        $targetFileSystem = new Filesystem(new InMemory());

        $mapping = array(
            'DataClass' => array(
                'root' => 'data',
                'fields' => array('alpha' => 'name', 'beta' => 'description', 'gamma' => 'notes'),
            ),
            'Beta' => array(
                'fields' => array('bravo' => 'title', 'charlie' => 'body'),
            ),
        );

        return new FOPManager($processor, $targetFileSystem, $tempFileSystem, $mapping, 'FruitFOP\Entity\Source');
    }

    protected function isPdf($pdf)
    {
        $pdfHeader = "\x25\x50\x44\x46\x2D";

        return strncmp($pdf, $pdfHeader, strlen($pdfHeader)) === 0 ? true : false;
    }
}

class DataClass
{
    protected $alpha;
    public $beta;
    private $gamma;
    private $notUsed = 'ever';

    public function __construct($alpha, $beta, array $gamma)
    {
        $this->alpha = $alpha;
        $this->beta = $beta;
        $this->gamma = $gamma;
    }
}

class Beta
{
    protected $bravo;
    protected $charlie;

    public function __construct()
    {
        $this->bravo = 'bravo';
        $this->charlie = 'charlie';
    }
}