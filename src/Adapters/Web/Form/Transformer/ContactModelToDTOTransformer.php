<?php

namespace BelkinDom\Adapters\Web\Form\Transformer;

use BelkinDom\DTO\Contact\Contact;
use BelkinDom\Store\Contact\Contact as ContactModel;
use BelkinDom\Store\Contact\ContactUuid;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ContactModelToDTOTransformer implements DataTransformerInterface
{
    /**
     * Transforms a Model to a DTO.
     *
     * @param  ContactModel|null $model
     * @return Contact
     */
    public function transform($model)
    {
        $contact = new Contact;

        if ($model) {
            $contact->setContactUuid((string) $model->ContactUuid());
            $contact->setPersonName($model->personName());
            $contact->setPersonEmail($model->personEmail());
            $contact->setPersonPhone($model->personPhone());
            $contact->setMessage($model->message());
        }

        return $contact;
    }

    /**
     * Transforms a DTO to a Model.
     *
     * @param  Contact $dto
     * @return ContactModel
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($dto)
    {
        return new ContactModel(
            $dto->getContactUuid() ? ContactUuid::existing($dto->getContactUuid()) : ContactUuid::generated(),
            (string) $dto->getPersonName(),
            (string) $dto->getPersonEmail(),
            (string) $dto->getPersonPhone(),
            (string) $dto->getMessage()
        );
    }
}
