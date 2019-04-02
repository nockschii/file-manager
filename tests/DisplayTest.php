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
        $testFile->setName("TestFile.txt");
        $this->display->setAllFiles([$testFile]);

        $actual = $this->display->allFiles();

        $expected = "<form action=\"content/deletefile.php?name=TestFile.txt\"method=\"post\"><p><button name=\"name\" type=\"submit\" style=\"margin-right: 1em\">delete</button><a href='content/content.php?name=TestFile.txt'>TestFile.txt</a></p></form>";
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function allFilesReturnStringToEchoIfTwoFilesAreInDirectory()
    {
        $testFileOne = new File();
        $testFileOne->setName("TestFile.txt");

        $testFileTwo = new File();
        $testFileTwo->setName("TestFile2.txt");
        $this->display->setAllFiles([$testFileOne, $testFileTwo]);

        $expected = "<form action=\"content/deletefile.php?name=TestFile.txt\"method=\"post\"><p><button name=\"name\" type=\"submit\" style=\"margin-right: 1em\">delete</button><a href='content/content.php?name=TestFile.txt'>TestFile.txt</a></p></form><form action=\"content/deletefile.php?name=TestFile2.txt\"method=\"post\"><p><button name=\"name\" type=\"submit\" style=\"margin-right: 1em\">delete</button><a href='content/content.php?name=TestFile2.txt'>TestFile2.txt</a></p></form>";
        $this->assertEquals($expected, $this->display->allFiles());
    }

    /**
     * @test
     */
    public function displayFileContent_ReturnContentAsString_WithGivenFile()
    {
        $testFile = new File();
        $testFile->setName("TestFile.txt");
        $testFile->setPath(FileHandler::UPLOAD_PATH."/"."TestFile.txt");
        $testFile->setContent("Test123");
        $this->display->setAllFiles([$testFile]);

        $this->assertEquals("Test123", $this->display->fileContent("TestFile.txt"));
    }

    public function tearDown()
    {
        $this->display->deleteFile("TestFile.txt");
    }
}