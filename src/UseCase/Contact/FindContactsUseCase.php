<?php

namespace BelkinDom\UseCase\Contact;

use BelkinDom\DTO\Request\Common\Find;
use BelkinDom\Store\Contact\Contact;
use BelkinDom\Store\Contact\Contacts;
use Pagerfanta\Pagerfanta;

class FindContactsUseCase
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
     * @param Find $findRequest
     *
     * @return Contact[]|Pagerfanta
     */
    public function execute(Find $findRequest)
    {
        return $this->contacts->list($findRequest);
    }
}
