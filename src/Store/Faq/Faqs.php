<?php

namespace BelkinDom\Store\Faq;

interface Faqs
{
    /**
     * @return Faq
     *
     * @throws FaqNotFoundException
     */
    public function get(): Faq;

    /**
     * @param Faq $faq
     */
    public function save(Faq $faq);

    /**
     * @param Faq $faq
     */
    public function update(Faq $faq);
}
