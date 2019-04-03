<?php

namespace FileManager;

class ContentController
{
    private $fileHandler;

    public function __construct(FileHandler $fileHandler)
    {
        $this->fileHandler = $fileHandler;
    }

    public function displayAllFiles(): string
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
        $action = '<form action="content/actiondone.php?name=' . $file->getFileName() . '&method=delete"method="post">';
        $button = '<p><button name="name" type="submit" style="margin-right: 1em">delete</button>';
        $name = '<a href=\'content/content.php?name=' . $file->getFileName() . '\'>' . $file->getFileName() . '</a></p></form>';
        $htmlText = $action . $button . $name;
        return $htmlText;
    }

    public function getFileContent($fileName): string
    {
        $content = "";
        /** @var File $file */
        foreach ($this->fileHandler->getAllFiles() as $file) {
            if ($file->getFileName() === $fileName) {
                $content = $file->getContent();
            }
        }
        return rtrim($content);
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

    // TODO Implement frontend
    public function filterFiles($input): array
    {
        $matches = $this->fileHandler->filterFiles($input);
        return $matches;
    }
}