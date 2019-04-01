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
            $begin = '<p><a href=\'content.php?name=';
            $tmpFileName = $file->getName();
            $end = '\'>'.$file->getName().'</a></p>';
            $displayString .= $begin.$tmpFileName.$end;
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
            if($file->getName() === $fileName){
                $content = $file->getContent();
            }
        }
        return $content;
    }

    public function saveContent(string $fileName, string $newContent)
    {
        $this->fileHandler->saveContent($fileName, $newContent);
    }
}