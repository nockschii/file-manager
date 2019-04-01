<?php

namespace FileManager;

class File
{
    private $name;
    private $path;
    private $content;

    public function init($name)
    {
        $this->setName($name);
        $this->setPath(FileHandler::UPLOAD_PATH . '/' . $name);
        $tmpContent = file_get_contents(FileHandler::UPLOAD_PATH . '/' . $name);
        $this->setContent($tmpContent);
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): void
    {
        $openFile = fopen($this->path, "w");
        fwrite($openFile, $content);
        fclose($openFile);
        $this->content = $content;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($fileName): void
    {
        $this->name = $fileName;
    }

    public function renameFile($newName): void
    {
        rename($this->path,FileHandler::UPLOAD_PATH.'/'.$newName);
        $this->name = $newName;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path): void
    {
        $this->path = $path;
    }
}