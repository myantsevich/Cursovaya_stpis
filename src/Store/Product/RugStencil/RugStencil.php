<?php

namespace BelkinDom\Store\Product\RugStencil;

use BelkinDom\Store\File\File;

class RugStencil
{
    /**
     * @var RugStencilUuid
     */
    private $rugStencilUuid;

    /**
     * @var File
     */
    private $file;

    public function __construct(RugStencilUuid $rugStencilUuid, File $file)
    {
        $this->rugStencilUuid = $rugStencilUuid;
        $this->file = $file;
    }

    public static function generated(File $file): RugStencil
    {
        return new self(RugStencilUuid::generated(), $file);
    }

    /**
     * @return RugStencilUuid
     */
    public function rugStencilUuid(): RugStencilUuid
    {
        return $this->rugStencilUuid;
    }

    /**
     * @return File
     */
    public function file(): File
    {
        return $this->file;
    }
}
