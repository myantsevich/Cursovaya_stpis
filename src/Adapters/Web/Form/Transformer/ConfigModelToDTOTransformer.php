<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Web\Config;
use BelkinDom\Store\Web\Config as ConfigModel;
use BelkinDom\Store\Web\ConfigUuid;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ConfigModelToDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param  ConfigModel|null $model
     * @return Config
     */
    public function transform($model)
    {
        $config = new Config;

        if ($model) {
            $config->setConfigUuid((string) $model->ConfigUuid());
            $config->setAboutText($model->aboutText());
            $config->setLeadText($model->leadText());
            $config->setOrderFlashEnabled($model->orderFlashEnabled());
            $config->setOrderFlashText($model->orderFlashText());
            $config->setInstagramUrl($model->instagramUrl());
            $config->setInstagramAccessToken($model->instagramAccessToken());
            $config->setInstagramClientId($model->instagramClientId());
            $config->setinstagramClientSecret($model->instagramClientSecret());
        }

        return $config;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  Config $dto
     * @return ConfigModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        return new ConfigModel(
            ConfigUuid::existing($dto->getConfigUuid()),
            $dto->getAboutText(),
            $dto->getLeadText(),
            (bool) $dto->isOrderFlashEnabled(),
            $dto->getOrderFlashText(),
            (string) $dto->getInstagramUrl(),
            (string) $dto->getInstagramAccessToken(),
            (string) $dto->getInstagramClientId(),
            (string) $dto->getInstagramClientSecret()
        );
    }
}
