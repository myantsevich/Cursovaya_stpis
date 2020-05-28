<?php

namespace BelkinDom\Store\File;

interface FileStorageInterface
{
    /**
     * @param File $file
     *
     * @throws FileStorageException
     */
    public function put(File $file);
    /**
     * @param File $file
     *
     * @throws FileStorageException
     */
    public function remove(File $file);
}
