<?php

namespace BelkinDom\UseCase\Product\RugStencil;

use BelkinDom\Store\Product\RugStencil\RugStencil;
use BelkinDom\Store\Product\RugStencil\RugStencils;
use BelkinDom\UseCase\File\CreateFileUseCase;
use BelkinDom\UseCase\File\RemoveFileUseCase;

class RemoveRugStencilUseCase
{
    /**
     * @var RugStencils
     */
    private $rugStencils;

    /**
     * @var CreateFileUseCase
     */
    private $removeFileUseCase;

    public function __construct(RugStencils $rugStencils, RemoveFileUseCase $removeFileUseCase)
    {
        $this->rugStencils = $rugStencils;
        $this->removeFileUseCase = $removeFileUseCase;
    }

    /**
     * @param RugStencil $rugStencil
     */
    public function execute(RugStencil $rugStencil)
    {
        $this->removeFileUseCase->execute($rugStencil->file());
        $this->rugStencils->remove($rugStencil);
    }
}
