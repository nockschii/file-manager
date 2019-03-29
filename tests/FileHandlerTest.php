<?php

namespace FileManagerTests;

use FileManager\FileHandler;
use PHPUnit\Framework\TestCase;

class FileHandlerTest extends Testcase
{
    /**
     * @var FileHandler
     */
    private $fileHandler;

    public function setUp()
    {
        $this->fileHandler = new FileHandler();
    }

    /**
     * @test
     */
    public function getAllFilesFromDirectory_ReturnArrayNotEmpty_WithGivenPath()
    {
        $files = $this->fileHandler->getAllFilesFromDirectory();
        var_dump($files);
        assertNotEmpty($files);
    }
}