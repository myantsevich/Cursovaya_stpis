<?php

namespace BelkinDom\Store\File;

interface Files
{
    /**
     * @param File $file
     */
    public function save(File $file);

    /**
     * @param File $file
     */
    public function update(File $file);

    /**
     * @param File $file
     */
    public function remove(File $file);
}
