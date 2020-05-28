<?php

namespace BelkinDom\Store\Web;

use BelkinDom\Store\Common\TranslatableContent;

class Config
{
    /**
     * @var ConfigUuid
     */
    private $configUuid;

    /**
     * @var TranslatableContent
     */
    private $aboutText;

    /**
     * @var TranslatableContent
     */
    private $leadText;

    /**
     * @var bool
     */
    private $orderFlashEnabled;

    /**
     * @var TranslatableContent
     */
    private $orderFlashText;

    /**
     * @var string
     */
    private $instagramUrl;

    /**
     * @var string|null
     */
    private $instagramAccessToken;

    /**
     * @var string|null
     */
    private $instagramClientId;

    /**
     * @var string|null
     */
    private $instagramClientSecret;

    public function __construct(
        ConfigUuid $configUuid,
        TranslatableContent $aboutText,
        TranslatableContent $leadText,
        bool $orderFlashEnabled,
        TranslatableContent $orderFlashText,
        string $instagramUrl,
        string $instagramAccessToken = null,
        string $instagramClientId = null,
        string $instagramClientSecret = null
    ) {
        $this->configUuid = $configUuid;
        $this->aboutText = $aboutText;
        $this->leadText = $leadText;
        $this->orderFlashEnabled = $orderFlashEnabled;
        $this->orderFlashText = $orderFlashText;
        $this->instagramUrl = $instagramUrl;
        $this->instagramAccessToken = $instagramAccessToken;
        $this->instagramClientId = $instagramClientId;
        $this->instagramClientSecret = $instagramClientSecret;
    }

    /**
     * @return ConfigUuid
     */
    public function configUuid(): ConfigUuid
    {
        return $this->configUuid;
    }

    /**
     * @return TranslatableContent
     */
    public function aboutText(): TranslatableContent
    {
        return $this->aboutText;
    }

    /**
     * @return TranslatableContent
     */
    public function leadText(): TranslatableContent
    {
        return $this->leadText;
    }

    /**
     * @return bool
     */
    public function orderFlashEnabled(): bool
    {
        return $this->orderFlashEnabled;
    }

    /**
     * @return TranslatableContent
     */
    public function orderFlashText(): TranslatableContent
    {
        return $this->orderFlashText;
    }

    /**
     * @return string
     */
    public function instagramUrl(): string
    {
        return $this->instagramUrl;
    }

    /**
     * @return null|string
     */
    public function instagramAccessToken(): ?string
    {
        return $this->instagramAccessToken;
    }

    /**
     * @param string $accessToken
     */
    public function updateInstagramAccessToken(string $accessToken)
    {
        $this->instagramAccessToken = $accessToken;
    }

    /**
     * @return null|string
     */
    public function instagramClientId(): ?string
    {
        return $this->instagramClientId;
    }

    /**
     * @return null|string
     */
    public function instagramClientSecret(): ?string
    {
        return $this->instagramClientSecret;
    }
}
