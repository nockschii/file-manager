<?php

namespace FileManager;

class FileHandler
{
    const UPLOAD_PATH = __DIR__ . "/uploads";
    private $allFiles = [];

    public function getAllFilesFromDirectory()
    {
        $allFileNames = scandir(self::UPLOAD_PATH);
        $allFileNames = $this->cleanAndSortFiles($allFileNames);
        $this->generateFiles($allFileNames);

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

    /**
     * @param array $allFileNames
     */
    private function generateFiles(array $allFileNames)
    {
        foreach ($allFileNames as $fileName) {
            $tmpFile = new File();
            $tmpFile->init($fileName);
            $this->allFiles[] = $tmpFile;
        }
    }
}