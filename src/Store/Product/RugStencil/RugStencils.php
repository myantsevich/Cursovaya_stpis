<?php

namespace BelkinDom\Store\Product\RugStencil;

interface RugStencils
{
    /**
     * @param RugStencil $rugStencil
     */
    public function save(RugStencil $rugStencil);

    /**
     * @param RugStencil $rugStencil
     */
    public function update(RugStencil $rugStencil);

    /**
     * @param RugStencil $rugStencil
     */
    public function remove(RugStencil $rugStencil);
}
