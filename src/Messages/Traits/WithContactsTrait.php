<?php

namespace EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\Components\Contact;

/**
 * Contains setter, getter and factory methods for "Contact" component.
 *
 * @package EC\Poetry\Messages\Traits
 */
trait WithContactsTrait
{
    /**
     * @var \EC\Poetry\Messages\Components\Contact[]
     */
    private $contacts = [];

    /**
     * Add component.
     *
     * @param Contact $contact
     *      Contact instance.
     *
     * @return $this
     */
    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * Getter.
     *
     * @return \EC\Poetry\Messages\Components\Contact[]
     *   Property value.
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Setter.
     *
     * @param \EC\Poetry\Messages\Components\Contact[] $contacts
     *   Property value.
     *
     * @return $this
     */
    public function setContacts(array $contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * Factory method: create a new contact and return its instance.
     *
     * @return \EC\Poetry\Messages\Components\Contact
     *      Contact instance.
     */
    public function withContact()
    {
        $this->contacts[] = new Contact();

        return end($this->contacts);
    }
}
