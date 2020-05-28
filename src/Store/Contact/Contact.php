<?php

namespace BelkinDom\Store\Contact;

class Contact
{
    /**
     * @var ContactUuid
     */
    private $contactUuid;

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
    private $personPhone;

    /**
     * @var string
     */
    private $message;

    public function __construct(
        ContactUuid $contactUuid,
        string $personName,
        string $personEmail,
        string $personPhone,
        string $message
    ) {
        $this->contactUuid = $contactUuid;
        $this->personName = $personName;
        $this->personEmail = $personEmail;
        $this->personPhone = $personPhone;
        $this->message = $message;
    }

    public static function generated(
        string $personName,
        string $personEmail,
        string $personPhone,
        string $message
    ): Contact {
        return new self(ContactUuid::generated(), $personName, $personEmail, $personPhone, $message);
    }

    /**
     * @return ContactUuid
     */
    public function contactUuid(): ContactUuid
    {
        return $this->contactUuid;
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
    public function personPhone(): string
    {
        return $this->personPhone;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }
}
