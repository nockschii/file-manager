<?php

namespace FileManagerTests;

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
    public function getAllFilesFromDirectory_ReturnCleanedAndSortFiles()
    {
        $expected = ["FirstFile.txt", "SecondFile.txt", "ThirdFile.txt"];
        $allFiles = [".", "..", "SecondFile.txt","FirstFile.txt","ThirdFile.txt"];
        $stub = $this->createMock(FileHandler::class);
        $stub->method('getAllFilesFromDirectory')
            ->willReturn($allFiles);

        $sortedFiles = $this->fileHandler->cleanAndSortFiles($stub->getAllFilesFromDirectory());

        assertEquals($expected, $sortedFiles);
    }

    /**
     * @test
     */
    public function getAllFilesFromDirectory_ReturnArrayWithCorrectType()
    {
        $allFiles = $this->fileHandler->getAllFilesFromDirectory();
        assertContainsOnlyInstancesOf(File::class,$allFiles);
    }

    /**
     * @test
     */
    public function saveContent_GivenNameAndContent()
    {
        $testFile = $this->fileHandler->createFile("Test.txt");
        $this->fileHandler->addFile($testFile);
        $this->fileHandler->saveContent("Test.txt", "Test123");
        assertEquals("Test123", $testFile->getContent());
        $this->fileHandler->deleteFile("Test.txt");
    }

    /**
     * @test
     */
    public function renameFile_GivenName()
    {
        $testFile = $this->fileHandler->createFile("TestFileCreatedForTests.txt");
//        $this->fileHandler->addFile($testFile);

        $this->fileHandler->renameFile("TestFileCreatedForTests.txt", "RenamedFile.txt");

        assertEquals("RenamedFile.txt", $testFile->getName());
        $this->fileHandler->deleteFile($testFile->getName());
    }

    /**
     * @test
     */
    public function createFile_ReturnsFile_ThatExists()
    {
        $file = $this->fileHandler->createFile("newFile.txt");
        assertFileExists($file->getPath());
        $this->fileHandler->deleteFile($file->getName());
    }

    /**
     * @test
     */
    public function createFile_ReturnsFile_WithCorrectType()
    {
        $file = $this->fileHandler->createFile("newFile.txt");
        $this->fileHandler->addFile($file);
        assertInstanceOf(File::class, $file);
        $this->fileHandler->deleteFile($file->getName());
    }

    /**
     * @test
     */
    public function createFile_ReturnFileWith_IfFileExists()
    {
        $this->expectException(\Exception::class);
        $file = $this->fileHandler->createFile("alreadyExists.txt");
        $fileTwo = $this->fileHandler->createFile("alreadyExists.txt");
        $this->fileHandler->deleteFile($file->getName());
        $this->fileHandler->deleteFile($fileTwo->getName());
    }

    /**
     * @test
     */
    public function deleteFile_ReturnsTrue_IfFileIsDeleted()
    {
        $file = $this->fileHandler->createFile("deleteFile.txt");
        $path = $file->getPath();
        $this->fileHandler->deleteFile($file->getName());
        assertFileNotExists($path);
    }
}