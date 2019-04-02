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
        $testFile = new File();
        $this->initFilesForTesting($testFile);

        $this->fileHandler->setAllFiles([$testFile]);

        $this->fileHandler->saveContent("FirstFile.txt", "Test123");

        assertEquals("Test123", $testFile->getContent());
    }

    /**
     * @test
     */
    public function renameFile_GivenName()
    {
        $testFile = $this->fileHandler->createFile("TestFileCreatedForTests");
        $this->fileHandler->addFile($testFile);

        $this->fileHandler->renameFile("TestFileCreatedForTests.txt", "RenamedFile.txt");

        assertEquals("RenamedFile.txt", $testFile->getName());
    }

    /**
     * @test
     */
    public function createFile_ReturnsFile_ThatExists()
    {
        $file = $this->fileHandler->createFile("newFile");
        assertFileExists($file->getPath());
    }

    /**
     * @test
     */
    public function createFile_ReturnsFile_WithCorrectType()
    {
        $file = $this->fileHandler->createFile("newFile");
        assertInstanceOf(File::class, $file);
    }

    /**
     * @test
     */
    public function createFile_ReturnFileWith_IfFileExists()
    {
        $this->expectException(\Exception::class);
        $this->fileHandler->createFile("alreadyExists");
        $this->fileHandler->createFile("alreadyExists");
    }

    /**
     * @param File $testFile
     */
    private function initFilesForTesting(File $testFile): void
    {
        $testFile->setPath("TestFileCreatedForTests.txt");
        $testFile->setName("TestFileCreatedForTests.txt");
        $testFile->setContent("Test123");
    }
}