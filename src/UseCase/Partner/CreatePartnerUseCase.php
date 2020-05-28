<?php

namespace BelkinDom\UseCase\Partner;

use BelkinDom\Store\Partner\Partner;
use BelkinDom\Store\Partner\Partners;
use BelkinDom\UseCase\File\CreateFileUseCase;

class CreatePartnerUseCase
{
    /**
     * @var Partners
     */
    private $partners;

    /**
     * @var CreateFileUseCase
     */
    private $createFileUseCase;

    public function __construct(Partners $partners, CreateFileUseCase $createFileUseCase)
    {
        $this->partners = $partners;
        $this->createFileUseCase = $createFileUseCase;
    }

    /**
     * @param Partner $partner
     */
    public function execute(Partner $partner)
    {
        $this->createFileUseCase->execute($partner->image());
        $this->partners->save($partner);
    }
}
