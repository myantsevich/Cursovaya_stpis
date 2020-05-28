<?php

namespace BelkinDom\DTO\Partner;

class Partner
{
    /**
     * @var string|null
     */
    private $partnerUuid;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var int|null
     */
    private $discount;

    /**
     * @var string|null
     */
    private $code;

    private $image;

    /**
     * @return null|string
     */
    public function getPartnerUuid(): ?string
    {
        return $this->partnerUuid;
    }

    /**
     * @param null|string $partnerUuid
     */
    public function setPartnerUuid(?string $partnerUuid): void
    {
        $this->partnerUuid = $partnerUuid;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    /**
     * @param null|int $discount
     */
    public function setDiscount(?int $discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return null|string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param null|string $code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $previewImage
     */
    public function setImage($previewImage): void
    {
        $this->image = $previewImage;
    }
}
