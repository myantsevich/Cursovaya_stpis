<?php

namespace BelkinDom\Store\File;

class File
{
    /**
     * @var FileUuid
     */
    private $fileUuid;

    /**
     * @var string
     */
    private $mimeType;

    /**
     * @var string
     */
    private $originalFileName;

    /**
     * @var string|null
     */
    private $tempPath;

    /**
     * @var string|null
     */
    private $path;

    public function __construct(
        FileUuid $fileUuid,
        string $mimeType,
        string $originalFileName,
        string $path,
        string $tempPath = ''
    ) {
        $this->fileUuid = $fileUuid;
        $this->mimeType = $mimeType;
        $this->originalFileName = $originalFileName;
        $this->path = $path;
        $this->tempPath = $tempPath;
    }

    public static function generated(
        string $mimeType,
        string $originalFileName,
        string $path,
        string $tempPath = ''
    ): File {
        return new self(FileUuid::generated(), $mimeType, $originalFileName, $path, $tempPath);
    }

    /**
     * @param File $file
     *
     * @return bool
     */
    public function equalsTo(File $file)
    {
        return (string) $this->fileUuid === (string) $file->fileUuid()
            && (string) $this->mimeType === (string) $file->mimeType()
            && (string) $this->originalFileName === (string) $file->originalFileName()
            && (string) $this->path === (string) $file->path()
            && (string) $this->tempPath === (string) $file->tempPath();
    }

    /**
     * @return FileUuid
     */
    public function fileUuid(): FileUuid
    {
        return $this->fileUuid;
    }

    /**
     * @return string
     */
    public function mimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @return string
     */
    public function originalFileName(): string
    {
        return $this->originalFileName;
    }

    /**
     * @return string|null
     */
    public function tempPath(): ?string
    {
        return $this->tempPath;
    }

    /**
     * @return string|null
     */
    public function path(): ?string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function moveTo(string $path)
    {
        $this->path = $path;
    }
}
