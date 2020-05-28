<?php

namespace BelkinDom\Store\Product\Gallery;

interface Galleries
{
    /**
     * @param Gallery $gallery
     */
    public function save(Gallery $gallery): void;

    /**
     * @param Gallery $gallery
     */
    public function update(Gallery $gallery): void;
}
