<?php

namespace BelkinDom\DTO\Contact;

class Contact
{
    /**
     * @var string|null
     */
    private $contactUuid;

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
    private $personPhone;

    /**
     * @var string|null
     */
    private $message;

    /**
     * @return null|string
     */
    public function getContactUuid(): ?string
    {
        return $this->contactUuid;
    }

    /**
     * @param null|string $contactUuid
     */
    public function setContactUuid(?string $contactUuid): void
    {
        $this->contactUuid = $contactUuid;
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
    public function getPersonPhone(): ?string
    {
        return $this->personPhone;
    }

    /**
     * @param null|string $personPhone
     */
    public function setPersonPhone(?string $personPhone): void
    {
        $this->personPhone = $personPhone;
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
}
