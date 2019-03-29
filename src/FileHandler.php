<?php

namespace FileManager;

class FileHandler
{
    const UPLOAD_PATH = __DIR__ . "/uploads";
    private $allFiles = [];

    public function getAllFilesFromDirectory()
    {
        $this->allFiles = scandir(self::UPLOAD_PATH);
        $this->allFiles = $this->cleanAndSortFiles($this->allFiles);
        return $this->allFiles;
    }

    public function cleanAndSortFiles($allFiles): array
    {
        unset($allFiles[0]);
        unset($allFiles[1]);
        array_values($allFiles);
        sort($allFiles);
        return $allFiles;
    }
}