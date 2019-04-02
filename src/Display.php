<?php

namespace FileManager;

class Display
{
    private $fileHandler;
    private $allFiles;

    public function __construct(FileHandler $fileHandler)
    {
        $this->fileHandler = $fileHandler;
        $this->allFiles = $this->fileHandler->getAllDirectoryEntries();
    }

    public function allFiles(): string
    {
        $htmlText = "";
        /** @var File $file */
        foreach ($this->allFiles as $file) {
            $htmlText .= $this->convertToHtml($file);
        }

        if ($htmlText === "") $htmlText = "No files.";
        return $htmlText;
    }

    /**
     * @param File $file
     * @return string
     */
    private function convertToHtml(File $file): string
    {
        $first = '<form action="deletefile.php';
        $second = "?name={$file->getName()}";
        $third = '"method="post"><p><button name="name" type="submit" style="margin-right: 1em">delete</button><a href=\'content.php?name=';
        $fourth = $file->getName();
        $fifth = '\'>' . $file->getName() . '</a></p></form>';
        $htmlText = $first . $second . $third . $fourth . $fifth;
        return $htmlText;
    }

    public function fileContent($fileName): string
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

    public function saveContent(string $fileName, string $newContent): void
    {
        $this->fileHandler->saveContent($fileName, $newContent);
    }

    public function renameFile($oldName, $newName): void
    {
        $this->fileHandler->renameFile($oldName, $newName);
    }

    public function deleteFile($fileName): void
    {
        $this->fileHandler->deleteFile($fileName);
    }

    /**
     * @param $fileName
     * @throws \Exception
     */
    public function createFile($fileName)
    {
        $this->fileHandler->createFile($fileName);
    }

    /**
     * @param array $allFiles
     */
    public function setAllFiles(array $allFiles): void
    {
        $this->allFiles = $allFiles;
    }
}