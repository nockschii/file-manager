<?php

namespace FileManagerTests;

use FileManager\Display;
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
        $this->display->setAllFiles(["FirstFile.txt"]);
        $actual = $this->display->allFiles();
        $expected = "<p><a href=''>FirstFile.txt</a></p>";
        assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function allFilesReturnStringToEchoIfTwoFilesAreInDirectory()
    {
        $this->display->setAllFiles(["FirstFile.txt", "SecondFile.txt"]);
        $actual = $this->display->allFiles();
        $expected = "<p><a href=''>FirstFile.txt</a></p><p><a href=''>SecondFile.txt</a></p>";
        assertEquals($expected, $actual);
    }
}