<?php

namespace BelkinDom\Store\Contact;

use BelkinDom\DTO\Request\Common\Find;
use Pagerfanta\Pagerfanta;

interface Contacts
{
    /**
     * @param Find $findRequest
     *
     * @return Contact[]|Pagerfanta
     */
    public function list(Find $findRequest);

    /**
     * @param ContactUuid $orderUuid
     *
     * @return Contact
     *
     * @throws ContactNotFoundException
     */
    public function get(ContactUuid $orderUuid): Contact;

    /**
     * @param Contact $contact
     */
    public function save(Contact $contact);

    /**
     * @param Contact $contact
     */
    public function update(Contact $contact);
}
