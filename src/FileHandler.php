<?php

namespace FileManager;

class FileHandler
{
    const UPLOAD_PATH = __DIR__ . "/uploads";
    private $allFiles = [];

    public function getAllFilesFromDirectory()
    {
        $this->allFiles = scandir(self::UPLOAD_PATH);
        $this->cleanAndSortFiles();
        return $this->allFiles;
    }

    private function cleanAndSortFiles(): array
    {
        unset($this->allFiles[0]);
        unset($this->allFiles[1]);
        array_values($this->allFiles);
        sort($this->allFiles);
        return $this->allFiles;
    }
}