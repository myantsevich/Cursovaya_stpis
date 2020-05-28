<?php

namespace BelkinDom\Adapters\File\Local;

use BelkinDom\Store\File\File;
use BelkinDom\Store\File\FileStorageException;
use BelkinDom\Store\File\FileStorageInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;

class Storage implements FileStorageInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var ExtensionGuesser
     */
    private $extensionGuesser;

    /**
     * @var string
     */
    private $root;

    /**
     * @var string
     */
    private $uploadPath;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->extensionGuesser = ExtensionGuesser::getInstance();
    }

    /**
     * @param string $root
     * @param string $uploadPath
     */
    public function setDirectory(string $root, string $uploadPath): void
    {
        $this->root = $root;
        $this->uploadPath = $uploadPath;
    }

    public function put(File $file)
    {
        $extension = $this->extensionGuesser->guess($file->mimeType());
        $fileName = $file->fileUuid() . '.' . $extension;
        $target = implode(DIRECTORY_SEPARATOR, [$this->root, $this->uploadPath, $fileName]);

        try {
            $this->filesystem->copy($file->tempPath(), $target);
            $file->moveTo(DIRECTORY_SEPARATOR . $this->uploadPath . DIRECTORY_SEPARATOR . $fileName);
        } catch (\Exception $x) {
            throw new FileStorageException($x->getMessage());
        }
    }

    public function remove(File $file)
    {
        try {
            $this->filesystem->remove($this->root . $file->path());
        } catch (\Exception $x) {
            throw new FileStorageException($x->getMessage());
        }
    }
}
