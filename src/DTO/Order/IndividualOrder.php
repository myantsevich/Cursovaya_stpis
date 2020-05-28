<?php

namespace BelkinDom\DTO\Order;

class IndividualOrder
{
    /**
     * @var string|null
     */
    private $orderUuid;

    /**
     * @var string|null
     */
    private $personName;

    /**
     * @var string|null
     */
    private $personEmail;

    /**
     * @var string|null
     */
    private $message;

    /**
     * @var string|null
     */
    private $size;

    /**
     * @var string|null
     */
    private $shape;

    /**
     * @var string|null
     */
    private $material;

    /**
     * @return null|string
     */
    public function getOrderUuid(): ?string
    {
        return $this->orderUuid;
    }

    /**
     * @param null|string $orderUuid
     */
    public function setOrderUuid(?string $orderUuid): void
    {
        $this->orderUuid = $orderUuid;
    }

    /**
     * @return null|string
     */
    public function getPersonName(): ?string
    {
        return $this->personName;
    }

    /**
     * @param null|string $personName
     */
    public function setPersonName(?string $personName): void
    {
        $this->personName = $personName;
    }

    /**
     * @return null|string
     */
    public function getPersonEmail(): ?string
    {
        return $this->personEmail;
    }

    /**
     * @param null|string $personEmail
     */
    public function setPersonEmail(?string $personEmail): void
    {
        $this->personEmail = $personEmail;
    }

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param null|string $message
     */
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return null|string
     */
    public function getSize(): ?string
    {
        return $this->size;
    }

    /**
     * @param null|string $size
     */
    public function setSize(?string $size): void
    {
        $this->size = $size;
    }

    /**
     * @return null|string
     */
    public function getShape(): ?string
    {
        return $this->shape;
    }

    /**
     * @param null|string $shape
     */
    public function setShape(?string $shape): void
    {
        $this->shape = $shape;
    }

    /**
     * @return null|string
     */
    public function getMaterial(): ?string
    {
        return $this->material;
    }

    /**
     * @param null|string $material
     */
    public function setMaterial(?string $material): void
    {
        $this->material = $material;
    }
}
