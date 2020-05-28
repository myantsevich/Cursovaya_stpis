<?php

namespace BelkinDom\Store\Partner;

use BelkinDom\DTO\Request\Common\Find;
use Pagerfanta\Pagerfanta;

interface Partners
{
    /**
     * @param PartnerUuid $uuid
     *
     * @throws PartnerNotFoundException
     *
     * @return Partner
     */
    public function get(PartnerUuid $uuid): Partner;

    /**
     * @param Find $findRequest
     *
     * @return Partner[]|Pagerfanta
     */
    public function list(Find $findRequest);

    /**
     * @param Partner $partner
     */
    public function save(Partner $partner);

    /**
     * @param Partner $partner
     */
    public function update(Partner $partner);
}
