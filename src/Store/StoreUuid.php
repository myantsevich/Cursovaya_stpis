<?php

namespace BelkinDom\Store;

use Ramsey\Uuid\Uuid;

abstract class StoreUuid
{
    /**
     * @var string
     */
    private $uuid;

    private function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function existing(string $uuid)
    {
        return new static($uuid);
    }

    public static function generated()
    {
        return new static((string) Uuid::uuid4());
    }

    public function isEqual(StoreUuid $uuid)
    {
        return (string) $this === (string) $uuid;
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}
