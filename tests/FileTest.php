<?php

use FileManager\File;
use FileManager\FileHandler;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    /** @var FileHandler */
    private $fileHandler;
    /** @var File */
    private $file;

    public function setUp()
    {
        $this->fileHandler = new FileHandler();
        $this->file = $this->fileHandler->createFile("TestFile.txt");
    }
    
    /**
     * @test
     */
    public function initFile_WithNameAndNotEmptyContent_AllPropertiesAreSet()
    {
        $notEmpty[] = $this->file->getName();
        $notEmpty[] = $this->file->getPath();
        $notEmpty[] = $this->file->getContent();

        $this->assertCount(3, $notEmpty);
    }

    /**
     * @test
     */
    public function init_CorrectPath()
    {
        $this->assertEquals('C:\workspace\file-manager\src/uploads/TestFile.txt', $this->file->getPath());
    }

    public function tearDown()
    {
        $this->fileHandler->deleteFile("TestFile.txt");
    }
}