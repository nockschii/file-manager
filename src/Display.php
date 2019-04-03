<?php

namespace FileManager;

class Display
{
    private $fileHandler;

    public function __construct(FileHandler $fileHandler)
    {
        $this->fileHandler = $fileHandler;
    }

    public function allFiles(): string
    {
        $htmlText = "";
        /** @var File $file */
        foreach ($this->fileHandler->getAllFiles() as $file) {
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
        $first = '<form action="content/actiondone.php';
        $second = "?name={$file->getFileName()}&method=delete";
        $third = '"method="post"><p><button name="name" type="submit" style="margin-right: 1em">delete</button><a href=\'content/content.php?name=';
        $fourth = $file->getFileName();
        $fifth = '\'>' . $file->getFileName() . '</a></p></form>';
        $htmlText = $first . $second . $third . $fourth . $fifth;
        return $htmlText;
    }

    public function fileContent($fileName): string
    {
        $content = "";
        /** @var File $file */
        foreach ($this->fileHandler->getAllFiles() as $file) {
            if ($file->getFileName() === $fileName) {
                $content = $file->getContent();
            }
        }
        return $content;
    }

    public function saveContent(string $fileName, string $newContent): void
    {
        $this->fileHandler->saveContent($fileName, $newContent);
    }

    public function rename($oldName, $newName): void
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
    public function createFile($fileName): void
    {
        $this->fileHandler->createFile($fileName);
    }
}