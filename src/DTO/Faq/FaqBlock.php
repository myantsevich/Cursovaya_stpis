<?php

namespace BelkinDom\DTO\Faq;

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

    public function __construct()
    {
        $this->question = new TranslatableContent;
        $this->answer = new TranslatableContent;
    }

    /**
     * @return TranslatableContent
     */
    public function getQuestion(): TranslatableContent
    {
        return $this->question;
    }

    /**
     * @param TranslatableContent $question
     */
    public function setQuestion(TranslatableContent $question): void
    {
        $this->question = $question;
    }

    /**
     * @return TranslatableContent
     */
    public function getAnswer(): TranslatableContent
    {
        return $this->answer;
    }

    /**
     * @param TranslatableContent $answer
     */
    public function setAnswer(TranslatableContent $answer): void
    {
        $this->answer = $answer;
    }
}
