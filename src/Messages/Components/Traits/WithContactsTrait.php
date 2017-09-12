<?php

namespace EC\Poetry\Messages\Components\Traits;

use EC\Poetry\Messages\Components\Contact;

/**
 * Contains setter, getter and factory methods for "Contact" component.
 *
 * @package EC\Poetry\Messages\Components\Traits
 */
trait WithContactsTrait
{
    /**
     * @var \EC\Poetry\Messages\Components\Contact[]
     */
    private $contacts;

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
     * @param \EC\Poetry\Messages\Components\Contact $contacts
     *   Property value.
     *
     * @return $this
     */
    public function setContacts(Contact $contacts)
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
        static $index = 0;
        $contact = $this->contacts[$index] = new Contact();
        $index++;

        return $contact;
    }
}
