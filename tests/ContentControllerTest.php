<?php
// MethodName_StateUnderTest_ExpectedBehavior
namespace FileManagerTests;

use FileManager\ContentController;
use FileManager\File;
use FileManager\FileHandler;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ContentControllerTest extends TestCase
{
    /**
     * @var ContentController
     */
    private $controller;

    /**
     * @var FileHandler
     */
    private $fileHandler;

    public function setUp()
    {
        $this->fileHandler = new FileHandler();
        $this->controller = new ContentController($this->fileHandler);
    }

    /**
     * @dataProvider displayAllFilesDirectoryNotEmpty
     * @test
     * @param $expected
     * @param $fileNames
     * @throws \ReflectionException
     */
    public function displayAllFiles_DirectoryNotEmpty_ReturnsCorrectHtmlString($expected, $fileNames)
    {
        $setFilesForTest = [];
        foreach ($fileNames as $testFile)
        {
            $tempFile = new File();
            $tempFile->setFileName($testFile);
            $setFilesForTest[] = $tempFile;
        }
        $reflectionProperty = $this->getReflectionProperty($this->fileHandler, 'allFiles');
        $reflectionProperty->setValue($this->fileHandler, $setFilesForTest);
        //$this->fileHandler->setAllFiles($setFilesForTest);

        $htmlString = $this->controller->displayAllFiles();

        $this->assertEquals($expected, $htmlString);
    }

    /**
     * dataProvider
     * @return array
     */
    public function displayAllFilesDirectoryNotEmpty()
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
     * @throws \ReflectionException
     */
    public function displayAllFiles_DirectoryEmpty_ReturnsNoFiles()
    {
        $reflectionProperty = $this->getReflectionProperty($this->fileHandler, 'allFiles');
        $reflectionProperty->setValue($this->fileHandler, []);

        $htmlString = $this->controller->displayAllFiles();

        $this->assertEquals("No files.", $htmlString);
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function getFileContent_ValidFileName_ReturnCorrectContent()
    {
        $testFile = new File();
        $testFile->setFileName("TestFile.txt");
        $testFile->setFilePath(FileHandler::UPLOAD_PATH."/"."TestFile.txt");
        $testFile->setContent("Test123");
        $reflectionProperty = $this->getReflectionProperty($this->fileHandler, 'allFiles');
        $reflectionProperty->setValue($this->fileHandler, [$testFile]);

        $actualContent = $this->controller->getFileContent("TestFile.txt");

        $this->assertEquals("Test123", $actualContent);
    }

    /**
     * @param $object
     * @param $propertyName
     * @return \ReflectionProperty
     * @throws \ReflectionException
     */
    public function getReflectionProperty(&$object, $propertyName)
    {
        $reflection = new ReflectionClass(get_class($object));
        $reflectionProperty = $reflection->getProperty($propertyName);
        $reflectionProperty->setAccessible(true);

        return $reflectionProperty;
    }

    public function tearDown()
    {
        $this->controller->deleteFile("TestFile.txt");
    }
}