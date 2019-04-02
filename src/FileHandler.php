<?php

namespace FileManager;

class FileHandler
{
    const UPLOAD_PATH = __DIR__ . "/uploads";
    private $allFiles = [];

    public function getAllDirectoryEntries(): array
    {
        $allEntries = scandir(self::UPLOAD_PATH);
        $allEntries = $this->cleanAndSortFiles($allEntries);
        $this->initializeFilesAsObjects($allEntries);

        return $this->allFiles;
    }

    public function cleanAndSortFiles(array $allFiles): array
    {
        unset($allFiles[0]);
        unset($allFiles[1]);
        array_values($allFiles);
        sort($allFiles);
        return $allFiles;
    }

    private function initializeFilesAsObjects(array $allFileNames): void
    {
        foreach ($allFileNames as $fileName) {
            $tmpFile = new File();
            $tmpFile->initialize($fileName);
            $this->allFiles[] = $tmpFile;
        }
    }

    /**
     * @param $fileName
     * @return File
     * @throws \Exception
     */
    public function createFile(string $fileName): File
    {
        $path = $this->createDirectoryEntry($fileName);
        $newFile = $this->addToAllFiles($fileName, $path);
        return $newFile;
    }

    /**
     * @param $fileName
     * @return string
     * @throws \Exception
     */
    private function createDirectoryEntry(string $fileName): string
    {
        $path = $this->absolutePath($fileName);
        if (file_exists($path)) {
            throw new \Exception("File already exists.");
        }
        touch($path);
        return $path;
    }

    private function absolutePath(string $fileName): string
    {
        $path = FileHandler::UPLOAD_PATH . "/" . $fileName;
        return $path;
    }

    /**
     * @param $fileName
     * @param string $path
     * @return File
     */
    private function addToAllFiles(string $fileName, string $path): File
    {
        $newFile = new File();
        $newFile->setName($fileName);
        $newFile->setPath($path);
        $this->allFiles[] = $newFile;
        return $newFile;
    }

    public function saveContent(string $fileName, string $newContent): void
    {
        /** @var File $file */
        foreach ($this->allFiles as $file) {
            if ($this->hasSameName($fileName, $file)) {
                $file->setContent($newContent);
            }
        }
    }

    /**
     * @param string $fileName
     * @param File $file
     * @return bool
     */
    private function hasSameName(string $fileName, File $file): bool
    {
        return ($file->getName() === $fileName) ? true : false;
    }

    public function renameFile($oldName, $newName): void
    {
        /** @var File $file */
        foreach ($this->allFiles as $file) {
            if ($this->hasSameName($oldName, $file)) {
                $file->rename($newName);
            }
        }
    }

    public function deleteFile(string $fileName): void
    {
        $path = $this->absolutePath($fileName);
        if (file_exists($path)){
            $this->removeFileObject($fileName);
            unlink($path);
        }
    }

    private function removeFileObject(string $fileName): void
    {
        foreach ($this->allFiles as $file) {
            if ($this->hasSameName($fileName, $file)) {
                unset($this->allFiles, $file);
                if (!empty($this->allFiles)) array_values($this->allFiles);
            }
        }
    }

    public function setAllFiles(array $allFiles): void
    {
        $this->allFiles = $allFiles;
    }
}