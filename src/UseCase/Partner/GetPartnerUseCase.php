<?php

namespace BelkinDom\UseCase\Partner;

use BelkinDom\Store\Partner\Partner;
use BelkinDom\Store\Partner\PartnerNotFoundException;
use BelkinDom\Store\Partner\Partners;
use BelkinDom\Store\Partner\PartnerUuid;

class GetPartnerUseCase
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
     * @param PartnerUuid $partnerUuid
     *
     * @return Partner
     *
     * @throws PartnerNotFoundException
     */
    public function execute(PartnerUuid $partnerUuid): Partner
    {
        return $this->partners->get($partnerUuid);
    }
}
