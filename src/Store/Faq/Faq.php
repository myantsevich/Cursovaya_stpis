<?php

namespace BelkinDom\Store\Faq;

class Faq
{
    /**
     * @var FaqUuid
     */
    private $faqUuid;

    /**
     * @var FaqBlock[]
     */
    private $blocks;

    public function __construct(FaqUuid $faqUuid, array $blocks = [])
    {
        $this->faqUuid = $faqUuid;
        $this->blocks = $blocks;
    }

    /**
     * @return FaqUuid
     */
    public function faqUuid(): FaqUuid
    {
        return $this->faqUuid;
    }

    /**
     * @return FaqBlock[]
     */
    public function blocks(): array
    {
        return $this->blocks;
    }
}
