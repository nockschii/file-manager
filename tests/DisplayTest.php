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
        $testFile->init("FirstFile.txt");

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
        $testFileOne->init("FirstFile.txt");
        $testFileTwo = new File();
        $testFileTwo->init("SecondFile.txt");

        $this->display->setAllFiles([$testFileOne, $testFileTwo]);
        $actual = $this->display->allFiles();

        $expected = "<p><a href='content.php?name=FirstFile.txt'>FirstFile.txt</a></p><p><a href='content.php?name=SecondFile.txt'>SecondFile.txt</a></p>";
        assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function displayFileContent_ReturnContentAsString_WithGivenFile()
    {
        $testFileOne = new File();
        $testFileOne->init("FirstFile.txt");
        $testFileOne->setContent("Test123");

        $this->display->setAllFiles([$testFileOne]);

        assertEquals("<p>Test123</p>", $this->display->displayFileContent("FirstFile.txt"));
    }
}