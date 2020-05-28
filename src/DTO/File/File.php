<?php

namespace BelkinDom\DTO\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class File
{
    /**
     * @var string|null
     */
    private $fileUuid;

    /**
     * @var UploadedFile|null
     */
    private $uploadedFile;

    /**
     * @var string|null
     */
    private $mimeType;

    /**
     * @var string|null
     */
    private $originalFileName;

    /**
     * @var string|null
     */
    private $path;

    /**
     * @return string
     */
    public function getFileUuid(): string
    {
        return (string) $this->fileUuid;
    }

    /**
     * @param null|string $fileUuid
     */
    public function setFileUuid(?string $fileUuid): void
    {
        $this->fileUuid = $fileUuid;
    }

    /**
     * @return null|UploadedFile
     */
    public function getUploadedFile(): ?UploadedFile
    {
        return $this->uploadedFile;
    }

    /**
     * @param null|UploadedFile $uploadedFile
     */
    public function setUploadedFile(?UploadedFile $uploadedFile): void
    {
        $this->uploadedFile = $uploadedFile;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return (string) $this->mimeType;
    }

    /**
     * @param null|string $mimeType
     */
    public function setMimeType(?string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return string
     */
    public function getOriginalFileName(): string
    {
        return (string) $this->originalFileName;
    }

    /**
     * @param null|string $originalFileName
     */
    public function setOriginalFileName(?string $originalFileName): void
    {
        $this->originalFileName = $originalFileName;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return (string) $this->path;
    }

    /**
     * @param null|string $path
     */
    public function setPath(?string $path): void
    {
        $this->path = $path;
    }
}
