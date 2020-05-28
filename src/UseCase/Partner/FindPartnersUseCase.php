<?php

namespace BelkinDom\UseCase\Partner;

use BelkinDom\DTO\Request\Common\Find;
use BelkinDom\Store\Partner\Partner;
use BelkinDom\Store\Partner\Partners;
use Pagerfanta\Pagerfanta;

class FindPartnersUseCase
{
    /**
     * @var Partners
     */
    private $partners;

    public function __construct(Partners $partners)
    {
        $this->partners = $partners;
    }

    /**
     * @param Find $findRequest
     *
     * @return Partner[]|Pagerfanta
     */
    public function execute(Find $findRequest)
    {
        return $this->partners->list($findRequest);
    }
}
