<?php

namespace FileManager;

class File
{
    private $fileName;
    private $filePath;
    private $content;

    public function initialize($fileName)
    {
        $this->setFileName($fileName);
        $this->setFilePath(FileHandler::UPLOAD_PATH . '/' . $fileName);
        $tmpContent = file_get_contents(FileHandler::UPLOAD_PATH . '/' . $fileName);
        $this->setContent($tmpContent);
    }

    public function setFileName($fileName): void
    {
        $this->fileName = $fileName;
    }

    public function setFilePath($filePath): void
    {
        $this->filePath = $filePath;
    }

    public function setContent($content): void
    {
        $openFile = fopen($this->filePath, "w");
        fwrite($openFile, $content);
        fclose($openFile);
        $this->content = $content;
    }

    public function rename($newName): void
    {
        rename($this->filePath,FileHandler::UPLOAD_PATH.'/'.$newName);
        $this->fileName = $newName;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }
}