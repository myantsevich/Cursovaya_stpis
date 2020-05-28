<?php

namespace BelkinDom\Store\Order;

class IndividualOrder
{
    const
        MATERIAL_COTTON = 'cotton',
        MATERIAL_POLYESTER = 'polyester',
        MATERIAL_ACRYLIC = 'acrylic',

        MATERIAL_COTTON_LABEL = 'product.material.cotton',
        MATERIAL_POLYESTER_LABEL = 'product.material.polyester',
        MATERIAL_ACRYLIC_LABEL = 'product.material.acrylic'
    ;

    /**
     * @var OrderUuid
     */
    private $orderUuid;

    /**
     * @var string
     */
    private $personName;

    /**
     * @var string
     */
    private $personEmail;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $size;

    /**
     * @var string
     */
    private $shape;

    /**
     * @var string
     */
    private $material;

    public function __construct(
        OrderUuid $orderUuid,
        string $personName,
        string $personEmail,
        string $message,
        string $size,
        string $shape,
        string $material
    ) {
        $this->orderUuid = $orderUuid;
        $this->personName = $personName;
        $this->personEmail = $personEmail;
        $this->message = $message;
        $this->size = $size;
        $this->shape = $shape;
        $this->material = $material;
    }

    public static function generated(
        string $personName,
        string $personEmail,
        string $message,
        string $size,
        string $shape,
        string $material
    ): IndividualOrder {
        return new self(OrderUuid::generated(), $personName, $personEmail, $message, $size, $shape, $material);
    }

    /**
     * @return OrderUuid
     */
    public function orderUuid(): OrderUuid
    {
        return $this->orderUuid;
    }

    /**
     * @return string
     */
    public function personName(): string
    {
        return $this->personName;
    }

    /**
     * @return string
     */
    public function personEmail(): string
    {
        return $this->personEmail;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function size(): string
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function shape(): string
    {
        return $this->shape;
    }

    /**
     * @return string
     */
    public function material(): string
    {
        return $this->material;
    }
}
