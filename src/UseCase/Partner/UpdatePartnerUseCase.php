<?php

namespace BelkinDom\UseCase\Partner;

use BelkinDom\Store\Partner\Partner;
use BelkinDom\Store\Partner\Partners;
use BelkinDom\UseCase\File\UpdateFileUseCase;

class UpdatePartnerUseCase
{
    /**
     * @var Partners
     */
    private $partners;

    /**
     * @var UpdateFileUseCase
     */
    private $updateFileUseCase;

    public function __construct(Partners $partners, UpdateFileUseCase $updateFileUseCase)
    {
        $this->partners = $partners;
        $this->updateFileUseCase = $updateFileUseCase;
    }

    /**
     * @param Partner $partner
     * @param Partner $updatedPartner
     */
    public function execute(Partner $partner, Partner $updatedPartner)
    {
        if (!$partner->image()->equalsTo($updatedPartner->image())) {
            $this->updateFileUseCase->execute($partner->image(), $updatedPartner->image());
        }

        $partner = new Partner(
            $updatedPartner->partnerUuid(),
            $updatedPartner->name(),
            $updatedPartner->discount(),
            $updatedPartner->code(),
            $updatedPartner->image()
        );

        $this->partners->update($partner);
    }
}
