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
            $file = trim($file, '.txt');
            $displayString .= "<p>{$file}</p>";
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
}