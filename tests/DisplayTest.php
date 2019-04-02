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

        $expected = "<form action=\"deletefile.php?name=FirstFile.txt\"method=\"post\"><p><button name=\"name\" type=\"submit\" style=\"margin-right: 1em\">delete</button><a href='content.php?name=FirstFile.txt'>FirstFile.txt</a></p></form>";
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

        $expected = "<form action=\"deletefile.php?name=FirstFile.txt\"method=\"post\"><p><button name=\"name\" type=\"submit\" style=\"margin-right: 1em\">delete</button><a href='content.php?name=FirstFile.txt'>FirstFile.txt</a></p></form><form action=\"deletefile.php?name=SecondFile.txt\"method=\"post\"><p><button name=\"name\" type=\"submit\" style=\"margin-right: 1em\">delete</button><a href='content.php?name=SecondFile.txt'>SecondFile.txt</a></p></form>";
        assertEquals($expected, $this->display->allFiles());
    }

    /**
     * @test
     */
    public function displayFileContent_ReturnContentAsString_WithGivenFile()
    {
        $testFile = new File();
        $testFile->setName("FirstFile.txt");
        $testFile->setPath(FileHandler::UPLOAD_PATH."/"."FirstFile.txt");
        $testFile->setContent("Test123");
        $this->display->setAllFiles([$testFile]);

        assertEquals("Test123", $this->display->fileContent("FirstFile.txt"));
        $this->fileHandler->deleteFile($testFile->getName());
    }

}