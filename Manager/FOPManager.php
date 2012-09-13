<?php

namespace Fruit\FOPBundle\Manager;

use FruitFOP\Handler\ProcessorInterface;
use FruitFOP\Manager\FOPManager as BaseFOPManager;
use Gaufrette\Filesystem;

class FOPManager extends BaseFOPManager
{
    protected $mapping;

    public function __construct(ProcessorInterface $processor, Filesystem $targetFileSystem, Filesystem $tempFileSystem, array $mapping, $sourceClass)
    {
        $this->mapping = $mapping;

        parent::__construct($processor, $targetFileSystem, $tempFileSystem, $sourceClass);
    }

    /**
     * Create a pdf from a data source, creates random filename for generated pdf file
     *
     * @param mixed $data
     *
     * @return \Gaufrette\File
     */
    public function generateFromData($data)
    {
        $source = $this->createSource($data, $this->mapping);

        return $this->generateDocument($source);
    }
}
