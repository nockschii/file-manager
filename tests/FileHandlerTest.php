<?php

namespace FileManagerTests;

use Exception;
use FileManager\File;
use FileManager\FileHandler;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

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
    public function UploadDirectoryExists()
    {
        $this->assertDirectoryExists(FileHandler::UPLOAD_PATH);
    }

    /**
     * @test // MethodName_StateUnderTest_ExpectedBehavior
     */
    public function getAllDirectoryEntries_DirectoryNotEmpty_ReturnNotEmptyArray()
    {
        touch(FileHandler::UPLOAD_PATH.'/'."TestFile.txt");
        $files = $this->fileHandler->getAllDirectoryEntries();

        $this->assertNotEmpty($files);
    }

    /**
     * @test
     */
    public function getAllFilesFromDirectory_DirectoryNotEmpty_ArrayContainsFileObjects()
    {
        $allFiles = $this->fileHandler->getAllDirectoryEntries();
        $this->assertContainsOnlyInstancesOf(File::class,$allFiles);
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function cleanAndSortFiles_DirectoryNotEmpty_ReturnsCorrectArray()
    {
        $filesToBeSorted = [".", "..", "SecondFile.txt","FirstFile.txt","ThirdFile.txt"];

        $test = $this->invokeMethod($this->fileHandler, 'cleanAndSortFiles', [$filesToBeSorted]);

        $expected = ["FirstFile.txt", "SecondFile.txt", "ThirdFile.txt"];
        $this->assertEquals($expected, $test);
    }

    /**
     * @param $object
     * @param $methodName
     * @param array $parameters
     * @return \ReflectionMethod
     * @throws \ReflectionException
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }


    /**
     * @test
     * @throws Exception
     */
    public function createFile_ValidFileName_CreatesFileThatExistsInDirectory()
    {
        $file = $this->fileHandler->createFile("TestFile.txt");
        $this->assertFileExists($file->getFilePath());
    }

    /**
     * @test
     * @throws Exception
     */
    public function createFile_ValidFileName_IsAddedToAllFilesProperty()
    {
        $file = $this->fileHandler->createFile("TestFile.txt");

        $this->assertContains($file, $this->fileHandler->getAllFiles());
    }

    /**
     * @test
     * @throws Exception
     */
    public function createFile_ValidFileName_ReturnsCorrectInstance()
    {
        $file = $this->fileHandler->createFile("TestFile.txt");
        $this->assertInstanceOf(File::class, $file);
    }

    /**
     * @test
     * @throws Exception
     */
    public function createFile_FileNameAlreadyExists_ThrowsException()
    {
        $this->expectException(Exception::class);
        $this->fileHandler->createFile("TestFile.txt");
        $this->fileHandler->createFile("TestFile.txt");
    }

    /**
     * @test
     * @throws Exception
     */
    public function saveContent_ValidParameters_ContentHasChanged()
    {
        $testFile = $this->fileHandler->createFile("TestFile.txt");

        $this->fileHandler->saveContent("TestFile.txt", "Test123");

        $this->assertEquals("Test123", $testFile->getContent());
    }

    /**
     * @test
     * @throws Exception
     */
    public function renameFile_ValidParameters_NameHasChanged()
    {
        $testFile = $this->fileHandler->createFile("TestFile.txt");

        $this->fileHandler->renameFile("TestFile.txt", "RenamedFile.txt");

        $this->assertEquals("RenamedFile.txt", $testFile->getFileName());
    }

    /**
     * @test
     * @throws Exception
     */
    public function deleteFile_ValidFileName_FileDoesNotExist()
    {
        $file = $this->fileHandler->createFile("TestFile.txt");
        $path = $file->getFilePath();

        $this->fileHandler->deleteFile($file->getFileName());

        $this->assertFileNotExists($path);
    }

    public function tearDown()
    {
        $this->fileHandler->deleteFile("TestFile.txt");
        $this->fileHandler->deleteFile("RenamedFile.txt");
    }
}