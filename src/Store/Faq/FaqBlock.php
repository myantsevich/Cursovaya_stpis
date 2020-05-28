<?php

namespace BelkinDom\Store\Faq;

use BelkinDom\Store\Common\TranslatableContent;

class FaqBlock
{
    /**
     * @var TranslatableContent
     */
    private $question;

    /**
     * @var TranslatableContent
     */
    private $answer;

    public function __construct(TranslatableContent $question, TranslatableContent $answer)
    {
        $this->question = $question;
        $this->answer = $answer;
    }

    /**
     * @return TranslatableContent
     */
    public function question(): TranslatableContent
    {
        return $this->question;
    }

    /**
     * @return TranslatableContent
     */
    public function answer(): TranslatableContent
    {
        return $this->answer;
    }
}
