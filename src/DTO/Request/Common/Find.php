<?php

namespace BelkinDom\DTO\Request\Common;

class Find
{
    const
        PAGE = 1,
        LIMIT = 30
    ;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $limit;

    public function __construct(int $page, int $limit)
    {
        $this->page = $page;
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function page(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function limit(): int
    {
        return $this->limit;
    }
}
