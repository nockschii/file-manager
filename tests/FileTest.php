<?php
// MethodName_StateUnderTest_ExpectedBehavior
use FileManager\File;
use FileManager\FileHandler;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    /** @var FileHandler */
    private $fileHandler;
    /** @var File */
    private $file;

    public function setUp()
    {
        $this->fileHandler = new FileHandler();
        touch(FileHandler::UPLOAD_PATH . '/' . 'TestFile.txt');
        $this->file = new File();
    }

    /**
     * @test
     */
    public function initialize_ValidFileName_AllPropertiesAreSet()
    {
        $this->file->initialize('TestFile.txt');
        $notEmpty[] = $this->file->getFileName();
        $notEmpty[] = $this->file->getFilePath();
        $notEmpty[] = $this->file->getContent();

        $this->assertCount(3, $notEmpty);
    }

    /**
     * @test
     */
    public function initialize_ValidFileName_ReturnCorrectPath()
    {
        $this->file->initialize('TestFile.txt');

        $this->assertEquals('C:\workspace\file-manager\src/uploads/TestFile.txt', $this->file->getFilePath());
    }

    public function tearDown()
    {
        $this->fileHandler->deleteFile("TestFile.txt");
    }
}