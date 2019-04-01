<?php

namespace FileManager;

class Display
{
    private $fileHandler;
    private $allFiles;

    public function __construct(FileHandler $fileHandler)
    {
        $this->fileHandler = $fileHandler;
        $this->allFiles = $this->fileHandler->getAllFilesFromDirectory();
    }

    public function allFiles()
    {
        $displayString = "";
        foreach ($this->allFiles as $file) {
            $displayString .= "<p><a href=''>{$file}</a></p>";
        }
        return $displayString;
    }

    /**
     * @param array $allFiles
     */
    public function setAllFiles(array $allFiles): void
    {
        $this->allFiles = $allFiles;
    }

    public function saveOnServer()
    {
        $_SERVER["uploads"] = $this->allFiles();
    }
}