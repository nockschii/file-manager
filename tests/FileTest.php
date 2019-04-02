<?php

use FileManager\File;
use FileManager\FileHandler;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    /**
     * @test
     */
    public function initFile_WithNameAndNotEmptyContent_AllPropertiesAreSet()
    {
        $fileHandler = new FileHandler();
        $file = $fileHandler->createFile("Test");
        $file->init("Test.txt");

        $notEmpty[] = $file->getName();
        $notEmpty[] = $file->getPath();
        $notEmpty[] = $file->getContent();

        assertCount(3, $notEmpty);
    }

    /**
     * @test
     */
    public function init_CorrectPath()
    {
        $file = new File();
        $file->init("Test.txt");

        assertEquals('C:\workspace\file-manager\src/uploads/Test.txt', $file->getPath());
    }
}