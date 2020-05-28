<?php

namespace BelkinDom\Adapters\Web\Controller;

use BelkinDom\DTO\Request\Common\Find;
use Symfony\Component\HttpFoundation\Request;

trait FindTrait
{
    public function createFindRequest(Request $request): Find
    {
        return new Find(
            $request->get('page', Find::PAGE),
            $request->get('limit', Find::LIMIT)
        );
    }
}
