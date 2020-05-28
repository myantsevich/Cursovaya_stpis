<?php

namespace BelkinDom\UseCase\Contact;

use BelkinDom\Store\Contact\Contact;
use BelkinDom\Store\Contact\ContactNotFoundException;
use BelkinDom\Store\Contact\Contacts;
use BelkinDom\Store\Contact\ContactUuid;

class GetContactUseCase
{
    /**
     * @var Contacts
     */
    private $contacts;

    public function __construct(Contacts $contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * @param ContactUuid $contactUuid
     *
     * @return Contact
     *
     * @throws ContactNotFoundException
     */
    public function execute(ContactUuid $contactUuid): Contact
    {
        return $this->contacts->get($contactUuid);
    }
}
