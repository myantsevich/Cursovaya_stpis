<?php

namespace BelkinDom\UseCase\Contact;

use BelkinDom\Store\Contact\Contact;
use BelkinDom\Store\Contact\Contacts;

class CreateContactUseCase
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
     * @param Contact $contact
     */
    public function execute(Contact $contact)
    {
        return $this->contacts->save($contact);
    }
}
