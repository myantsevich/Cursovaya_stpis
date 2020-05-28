<?php

namespace BelkinDom\UseCase\File;

use BelkinDom\Store\File\File;
use BelkinDom\Store\File\Files;
use BelkinDom\Store\File\FileStorageInterface;

class RemoveFileUseCase
{
    /**
     * @var Files
     */
    private $files;

    /**
     * @var FileStorageInterface
     */
    private $fileStorage;

    public function __construct(Files $files, FileStorageInterface $fileStorage)
    {
        $this->files = $files;
        $this->fileStorage = $fileStorage;
    }

    /**
     * @param File $file
     */
    public function execute(File $file)
    {
        $this->fileStorage->remove($file);
        $this->files->remove($file);
    }
}
