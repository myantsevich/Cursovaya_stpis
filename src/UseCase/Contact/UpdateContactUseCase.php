<?php

namespace BelkinDom\UseCase\Contact;

use BelkinDom\Store\Contact\Contact;
use BelkinDom\Store\Contact\Contacts;

class UpdateContactUseCase
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
     * @param Contact $updatedContact
     */
    public function execute(Contact $contact, Contact $updatedContact)
    {
        return $this->contacts->update($contact);
    }
}
