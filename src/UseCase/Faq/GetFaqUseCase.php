<?php

namespace BelkinDom\UseCase\Faq;

use BelkinDom\Store\Faq\Faq;
use BelkinDom\Store\Faq\FaqNotFoundException;
use BelkinDom\Store\Faq\Faqs;

class GetFaqUseCase
{
    /**
     * @var Faqs
     */
    private $faqs;

    /**
     * @var CreateFaqUseCase
     */
    private $createFaqUseCase;

    public function __construct(Faqs $faqs, CreateFaqUseCase $createFaqUseCase)
    {
        $this->faqs = $faqs;
        $this->createFaqUseCase = $createFaqUseCase;
    }

    /**
     * @return Faq
     */
    public function execute(): Faq
    {
        try {
            $faq = $this->faqs->get();
        } catch (FaqNotFoundException $x) {
            $faq = $this->createFaqUseCase->execute();
        }

        return $faq;
    }
}
