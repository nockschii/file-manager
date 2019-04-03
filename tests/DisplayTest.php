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
     * @dataProvider allFilesDirectoryNotEmpty
     * @test // MethodName_StateUnderTest_ExpectedBehavior
     * @param $expected
     * @param $fileNames
     */
    public function allFiles_DirectoryNotEmpty_ReturnsCorrectHtmlString($expected, $fileNames)
    {
        $setFilesForTest = [];
        foreach ($fileNames as $testFile)
        {
            $tempFile = new File();
            $tempFile->setFileName($testFile);
            $setFilesForTest[] = $tempFile;
        }
        $this->fileHandler->setAllFiles($setFilesForTest);

        $htmlString = $this->display->allFiles();

        $this->assertEquals($expected, $htmlString);
    }

    /**
     * dataProvider
     * @return array
     */
    public function allFilesDirectoryNotEmpty()
    {
        return [
            ["<form action=\"content/actiondone.php?name=TestFile.txt&method=delete\"method=\"post\"><p><button name=\"name\" type=\"submit\" style=\"margin-right: 1em\">delete</button><a href='content/content.php?name=TestFile.txt'>TestFile.txt</a></p></form>",
                ["TestFile.txt"]
            ],
            ["<form action=\"content/actiondone.php?name=TestFile.txt&method=delete\"method=\"post\"><p><button name=\"name\" type=\"submit\" style=\"margin-right: 1em\">delete</button><a href='content/content.php?name=TestFile.txt'>TestFile.txt</a></p></form><form action=\"content/actiondone.php?name=TestFile2.txt&method=delete\"method=\"post\"><p><button name=\"name\" type=\"submit\" style=\"margin-right: 1em\">delete</button><a href='content/content.php?name=TestFile2.txt'>TestFile2.txt</a></p></form>",
                ["TestFile.txt", "TestFile2.txt"]
            ]
        ];
    }

    /**
     * @test
     */
    public function allFiles_DirectoryEmpty_ReturnsNoFiles()
    {
        $this->fileHandler->setAllFiles([]);

        $htmlString = $this->display->allFiles();

        $this->assertEquals("No files.", $htmlString);
    }

    /**
     * @test
     */
    public function fileContent_ValidFileName_ReturnCorrectContent()
    {
        $testFile = new File();
        $testFile->setFileName("TestFile.txt");
        $testFile->setFilePath(FileHandler::UPLOAD_PATH."/"."TestFile.txt");
        $testFile->setContent("Test123");
        $this->fileHandler->setAllFiles([$testFile]);

        $actualContent = $this->display->fileContent("TestFile.txt");

        $this->assertEquals("Test123", $actualContent);
    }

    public function tearDown()
    {
        $this->display->deleteFile("TestFile.txt");
    }
}