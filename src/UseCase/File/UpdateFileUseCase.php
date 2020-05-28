<?php

namespace BelkinDom\UseCase\File;

use BelkinDom\Store\File\File;
use BelkinDom\Store\File\Files;
use BelkinDom\Store\File\FileStorageInterface;

class UpdateFileUseCase
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
     * @param File $updatedFile
     */
    public function execute(File $file, File $updatedFile)
    {
        $this->fileStorage->remove($file);
        $this->fileStorage->put($updatedFile);
        $this->files->update($updatedFile);
    }
}
