<?php

namespace FileManagerTests;

use Exception;
use FileManager\File;
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
        $this->assertDirectoryExists(FileHandler::UPLOAD_PATH);
    }

    /**
     * @test
     */
    public function getAllFilesFromDirectory_ReturnArrayNotEmpty_WithGivenPath()
    {
        $files = $this->fileHandler->getAllDirectoryEntries();

        $this->assertNotEmpty($files);
    }

    /**
     * @test
     */
    public function getAllFilesFromDirectory_ReturnCleanedAndSortFiles()
    {
        $expected = ["FirstFile.txt", "SecondFile.txt", "ThirdFile.txt"];
        $allFiles = [".", "..", "SecondFile.txt","FirstFile.txt","ThirdFile.txt"];
        $stub = $this->createMock(FileHandler::class);
        $stub->method('getAllDirectoryEntries')
            ->willReturn($allFiles);

        $sortedFiles = $this->fileHandler->cleanAndSortFiles($stub->getAllDirectoryEntries());

        $this->assertEquals($expected, $sortedFiles);
    }

    /**
     * @test
     */
    public function getAllFilesFromDirectory_ReturnArrayWithCorrectType()
    {
        $allFiles = $this->fileHandler->getAllDirectoryEntries();
        $this->assertContainsOnlyInstancesOf(File::class,$allFiles);
    }

    /**
     * @test
     * @throws Exception
     */
    public function saveContent_GivenNameAndContent()
    {
        $testFile = $this->fileHandler->createFile("TestFile.txt");

        $this->fileHandler->saveContent("TestFile.txt", "Test123");

        $this->assertEquals("Test123", $testFile->getContent());
    }

    /**
     * @test
     * @throws Exception
     */
    public function renameFile_GivenName()
    {
        $testFile = $this->fileHandler->createFile("TestFile.txt");

        $this->fileHandler->renameFile("TestFile.txt", "RenamedFile.txt");

        $this->assertEquals("RenamedFile.txt", $testFile->getName());
    }

    /**
     * @test
     * @throws Exception
     */
    public function createFile_ReturnsFile_ThatExists()
    {
        $file = $this->fileHandler->createFile("TestFile.txt");
        $this->assertFileExists($file->getPath());
    }

    /**
     * @test
     * @throws Exception
     */
    public function createFile_ReturnsFile_WithCorrectType()
    {
        $file = $this->fileHandler->createFile("TestFile.txt");
        $this->assertInstanceOf(File::class, $file);
    }

    /**
     * @test
     * @throws Exception
     */
    public function createFile_ReturnFileWith_IfFileExists()
    {
        $this->expectException(Exception::class);
        $this->fileHandler->createFile("TestFile.txt");
        $this->fileHandler->createFile("TestFile.txt");
    }

    /**
     * @test
     * @throws Exception
     */
    public function deleteFile_ReturnsTrue_IfFileIsDeleted()
    {
        $file = $this->fileHandler->createFile("TestFile.txt");
        $path = $file->getPath();
        $this->fileHandler->deleteFile($file->getName());
        $this->assertFileNotExists($path);
    }

    public function tearDown()
    {
        $this->fileHandler->deleteFile("TestFile.txt");
        $this->fileHandler->deleteFile("RenamedFile.txt");
    }
}