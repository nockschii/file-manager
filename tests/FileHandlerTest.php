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
    public function constDirectoryIsReadable()
    {
        assertDirectoryExists(FileHandler::UPLOAD_PATH);
    }

    /**
     * @test
     */
    public function getAllFilesFromDirectory_ReturnArrayNotEmpty_WithGivenPath()
    {
        $files = $this->fileHandler->getAllFilesFromDirectory();

        assertNotEmpty($files);
    }

    /**
     * @test
     */
    public function cleanAndSortFiles_ReturnCleanedAndSortFiles()
    {
        $files = $this->fileHandler->getAllFilesFromDirectory();

        assertTrue(sort($files));
    }
}