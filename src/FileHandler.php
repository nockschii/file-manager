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

    private function generateFiles(array $allFileNames)
    {
        foreach ($allFileNames as $fileName) {
            $tmpFile = new File();
            $tmpFile->init($fileName);
            $this->allFiles[] = $tmpFile;
        }
    }

    public function saveContent(string $fileName, string $newContent)
    {
        /** @var File $file */
        foreach ($this->allFiles as $file) {
            if ($file->getName() === $fileName) {
                $file->setContent($newContent);
            }
        }
    }

    public function addFile($newFile)
    {
        $this->allFiles[] = $newFile;
    }

    public function createFile($fileName)
    {
        $fileName .= ".txt";
        $path = FileHandler::UPLOAD_PATH."/".$fileName;

        if (file_exists($path)) {
            throw new \Exception("File already exists.");
        }

        $newFile = new File();
        touch($path);
        $newFile->setName($fileName);
        $newFile->setPath($path);
        return $newFile;
    }

    public function renameFile($oldName, $newName)
    {
        /** @var File $file */
        foreach ($this->allFiles as $file) {
            if ($file->getName() === $oldName) {
                $file->renameFile($newName);
            }
        }
    }

    /**
     * @param array $allFiles
     */
    public function setAllFiles(array $allFiles): void
    {
        $this->allFiles = $allFiles;
    }
}