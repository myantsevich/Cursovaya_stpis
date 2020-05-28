<?php

namespace BelkinDom\UseCase\Faq;

use BelkinDom\Store\Faq\Faq;
use BelkinDom\Store\Faq\Faqs;
use BelkinDom\Store\Faq\FaqUuid;

class CreateFaqUseCase
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
     * @return Faq
     */
    public function execute(): Faq
    {
        $faq = new Faq(FaqUuid::generated(), []);
        $this->faqs->save($faq);

        return $faq;
    }
}
