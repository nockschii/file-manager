<?php

namespace FileManager;

class FileHandler
{
    const UPLOAD_PATH = __DIR__ . "/uploads";
    private $allFiles = [];

    public function getAllFilesFromDirectory()
    {
       return $this->allFiles = scandir(self::UPLOAD_PATH);
    }
}