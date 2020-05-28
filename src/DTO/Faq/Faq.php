<?php

namespace BelkinDom\DTO\Faq;

class Faq
{
    /**
     * @var string
     */
    private $faqUuid;

    /**
     * @var FaqBlock[]
     */
    private $blocks = [];

    /**
     * @return string
     */
    public function getFaqUuid(): string
    {
        return $this->faqUuid;
    }

    /**
     * @param string $faqUuid
     */
    public function setFaqUuid(string $faqUuid): void
    {
        $this->faqUuid = $faqUuid;
    }

    /**
     * @return FaqBlock[]
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }

    /**
     * @param FaqBlock[] $blocks
     */
    public function setBlocks(array $blocks = []): void
    {
        $this->blocks = $blocks;
    }
}
