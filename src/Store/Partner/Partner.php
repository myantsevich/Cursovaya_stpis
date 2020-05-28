<?php

namespace BelkinDom\Store\Partner;

use BelkinDom\Store\File\File;

class Partner
{
    /**
     * @var PartnerUuid
     */
    private $partnerUuid;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $discount;

    /**
     * @var string
     */
    private $code;

    /**
     * @var File
     */
    private $image;

    public function __construct(PartnerUuid $partnerUuid, string $name, int $discount, string $code, File $image)
    {
        $this->partnerUuid = $partnerUuid;
        $this->name = $name;
        $this->discount = $discount;
        $this->code = $code;
        $this->image = $image;
    }

    public static function generated(
        string $name,
        int $discount,
        string $code,
        File $image
    ): Partner {
        return new self(PartnerUuid::generated(), $name, $discount, $code, $image);
    }

    /**
     * @return PartnerUuid
     */
    public function partnerUuid(): PartnerUuid
    {
        return $this->partnerUuid;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function discount(): int
    {
        return $this->discount;
    }

    /**
     * @return string
     */
    public function code(): string
    {
        return $this->code;
    }

    /**
     * @return File
     */
    public function image(): File
    {
        return $this->image;
    }
}
