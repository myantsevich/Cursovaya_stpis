<?php

namespace BelkinDom\UseCase\Faq;

use BelkinDom\Store\Faq\Faq;
use BelkinDom\Store\Faq\Faqs;

class UpdateFaqUseCase
{
    /**
     * @var Faqs
     */
    private $faqs;

    public function __construct(Faqs $faqs)
    {
        $this->faqs = $faqs;
    }

    /**
     * @param Faq $faq
     */
    public function execute(Faq $faq)
    {
        $this->faqs->update($faq);
    }
}
