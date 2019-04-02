<?php

namespace FileManagerTests;

use FileManager\Display;
use FileManager\File;
use FileManager\FileHandler;
use PHPUnit\Framework\TestCase;

class DisplayTest extends TestCase
{
    /**
     * @var Display
     */
    private $display;

    /**
     * @var FileHandler
     */
    private $fileHandler;

    public function setUp()
    {
        $this->fileHandler = new FileHandler();
        $this->display = new Display($this->fileHandler);
    }

    /**
     * @test
     */
    public function allFiles_ReturnStringToEcho_IfOneFileIsInDirectory()
    {
        $testFile = new File();
        $testFile->setName("FirstFile.txt");
        $this->display->setAllFiles([$testFile]);



        $actual = $this->display->allFiles();

        $expected = "<p><a href='content.php?name=FirstFile.txt'>FirstFile.txt</a></p>";
        assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function allFilesReturnStringToEchoIfTwoFilesAreInDirectory()
    {
        $testFileOne = new File();
        $testFileOne->setName("FirstFile.txt");

        $testFileTwo = new File();
        $testFileTwo->setName("SecondFile.txt");
        $this->display->setAllFiles([$testFileOne, $testFileTwo]);

        $expected = "<p><a href='content.php?name=FirstFile.txt'>FirstFile.txt</a></p><p><a href='content.php?name=SecondFile.txt'>SecondFile.txt</a></p>";
        assertEquals($expected, $this->display->allFiles());
    }

    /**
     * @test
     */
    public function displayFileContent_ReturnContentAsString_WithGivenFile()
    {
        $testFile = $this->fileHandler->createFile("FirstFile.txt");
        $testFile->setContent("Test123");
        $this->display->setAllFiles([$testFile]);

        assertEquals("Test123", $this->display->displayFileContent("FirstFile.txt"));
        $this->fileHandler->deleteFile($testFile->getName());
    }

}