<?php

namespace BelkinDom\UseCase\Product\RugStencil;

use BelkinDom\Store\Product\RugStencil\RugStencil;
use BelkinDom\Store\Product\RugStencil\RugStencils;
use BelkinDom\UseCase\File\CreateFileUseCase;

class CreateRugStencilUseCase
{
    /**
     * @var RugStencils
     */
    private $rugStencils;

    /**
     * @var CreateFileUseCase
     */
    private $createFileUseCase;

    public function __construct(RugStencils $rugStencils, CreateFileUseCase $createFileUseCase)
    {
        $this->rugStencils = $rugStencils;
        $this->createFileUseCase = $createFileUseCase;
    }

    /**
     * @param RugStencil $stencil
     */
    public function execute(RugStencil $stencil)
    {
        $this->createFileUseCase->execute($stencil->file());
        $this->rugStencils->save($stencil);
    }
}
