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
        $this->setPath(FileHandler::UPLOAD_PATH.'/'.$name);
        $tmpContent = file_get_contents(FileHandler::UPLOAD_PATH.'/'.$name);
        $this->setContent($tmpContent);
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): void
    {
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

    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path): void
    {
        $this->path = $path;
    }
}