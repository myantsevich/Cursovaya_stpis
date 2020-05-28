<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\File\File;
use BelkinDom\Store\File\File as FileModel;
use BelkinDom\Store\File\FileUuid;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FileModelToDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param  FileModel|null $model
     * @return File
     */
    public function transform($model)
    {
        $file = new File();

        if ($model) {
            $file->setFileUuid((string) $model->fileUuid());
            $file->setMimeType($model->mimeType());
            $file->setOriginalFileName($model->originalFileName());
            $file->setPath($model->path());
        }

        return $file;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  File $dto
     * @return FileModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        $uploadedFile = $dto->getUploadedFile();

        $model = new FileModel(
            $dto->getFileUuid() ? FileUuid::existing($dto->getFileUuid()) : FileUuid::generated(),
            (string) $uploadedFile ? $uploadedFile->getMimeType() : $dto->getMimeType(),
            (string) $uploadedFile ? $uploadedFile->getClientOriginalName() : $dto->getOriginalFileName(),
            (string) $dto->getPath(),
            $uploadedFile ? $uploadedFile->getPathname() : ''
        );

        return $model;
    }
}
