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
        /** @var File $file */
        foreach ($this->allFiles as $file) {
            $first = '<form action="deletefile.php';
            $second = "?name={$file->getName()}";
            $third = '"method="post"><p><button name="name" type="submit" style="margin-right: 1em">delete</button><a href=\'content.php?name=';
            $fourth = $file->getName();
            $fifth = '\'>' . $file->getName() . '</a></p></form>';
            $displayString .= $first . $second . $third . $fourth . $fifth;
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

    public function displayFileContent($fileName): string
    {
        $content = "";
        /** @var File $file */
        foreach ($this->allFiles as $file) {
            if ($file->getName() === $fileName) {
                $content = $file->getContent();
            }
        }
        return $content;
    }

    public function saveContent(string $fileName, string $newContent)
    {
        $this->fileHandler->saveContent($fileName, $newContent);
    }

    public function renameFile($oldName, $newName)
    {
        $this->fileHandler->renameFile($oldName, $newName);
    }

    public function deleteFile($fileName)
    {
        $this->fileHandler->deleteFile($fileName);
    }
}