<?php

namespace BelkinDom\DTO\Web;

use BelkinDom\Store\Common\TranslatableContent;

class Config
{
    /**
     * @var string|null
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
     * @var string|null
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

    public function __construct()
    {
        $this->leadText = new TranslatableContent;
        $this->aboutText = new TranslatableContent;
        $this->orderFlashText = new TranslatableContent;
    }

    /**
     * @return null|string
     */
    public function getConfigUuid()
    {
        return $this->configUuid;
    }

    /**
     * @param null|string $configUuid
     */
    public function setConfigUuid($configUuid)
    {
        $this->configUuid = $configUuid;
    }

    /**
     * @return TranslatableContent
     */
    public function getAboutText(): TranslatableContent
    {
        return $this->aboutText;
    }

    /**
     * @param TranslatableContent $aboutText
     */
    public function setAboutText(TranslatableContent $aboutText): void
    {
        $this->aboutText = $aboutText;
    }

    /**
     * @return TranslatableContent
     */
    public function getLeadText(): TranslatableContent
    {
        return $this->leadText;
    }

    /**
     * @param TranslatableContent $leadText
     */
    public function setLeadText(TranslatableContent $leadText): void
    {
        $this->leadText = $leadText;
    }

    /**
     * @return bool
     */
    public function isOrderFlashEnabled(): bool
    {
        return $this->orderFlashEnabled;
    }

    /**
     * @param bool $orderFlashEnabled
     */
    public function setOrderFlashEnabled(bool $orderFlashEnabled = false)
    {
        $this->orderFlashEnabled = $orderFlashEnabled;
    }

    /**
     * @return TranslatableContent
     */
    public function getOrderFlashText(): TranslatableContent
    {
        return $this->orderFlashText;
    }

    /**
     * @param TranslatableContent $orderFlashText
     */
    public function setOrderFlashText(TranslatableContent $orderFlashText): void
    {
        $this->orderFlashText = $orderFlashText;
    }

    /**
     * @return null|string
     */
    public function getInstagramUrl()
    {
        return $this->instagramUrl;
    }

    /**
     * @param null|string $instagramUrl
     */
    public function setInstagramUrl($instagramUrl)
    {
        $this->instagramUrl = $instagramUrl;
    }

    /**
     * @return null|string
     */
    public function getInstagramAccessToken()
    {
        return $this->instagramAccessToken;
    }

    /**
     * @param null|string $instagramAccessToken
     */
    public function setInstagramAccessToken($instagramAccessToken)
    {
        $this->instagramAccessToken = $instagramAccessToken;
    }

    /**
     * @return null|string
     */
    public function getInstagramClientId()
    {
        return $this->instagramClientId;
    }

    /**
     * @param null|string $instagramClientId
     */
    public function setInstagramClientId($instagramClientId)
    {
        $this->instagramClientId = $instagramClientId;
    }
    /**
     * @return null|string
     */
    public function getInstagramClientSecret()
    {
        return $this->instagramClientSecret;
    }

    /**
     * @param null|string $instagramClientSecret
     */
    public function setInstagramClientSecret($instagramClientSecret)
    {
        $this->instagramClientSecret = $instagramClientSecret;
    }
}
