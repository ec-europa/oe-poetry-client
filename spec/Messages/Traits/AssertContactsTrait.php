<?php

namespace spec\EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\Components\Contact;

/**
 * Trait AssertContactsTrait
 *
 * @method addContact(Contact $contact)
 * @method getContacts()
 * @method setContacts(array $contacts)
 * @method withContact()
 *
 * @package spec\EC\Poetry\Messages\Traits
 */
trait AssertContactsTrait
{
    /**
     * Assert Component.
     *
     * @param \EC\Poetry\Messages\Components\Contact $contact1
     * @param \EC\Poetry\Messages\Components\Contact $contact2
     * @param \EC\Poetry\Messages\Components\Contact $contact3
     * @param \EC\Poetry\Messages\Components\Contact $contact4
     */
    function assertContacts($contact1, $contact2, $contact3, $contact4)
    {
        $this->addContact($contact1)->shouldReturn($this);
        $this->addContact($contact2)->shouldReturn($this);
        $this->getContacts()->shouldBeArray();
        $this->getContacts()[0]->shouldBe($contact1);
        $this->getContacts()[1]->shouldBe($contact2);

        $this->setContacts([$contact3, $contact4])->shouldReturn($this);
        $this->getContacts()[0]->shouldNotBe($contact1);
        $this->getContacts()[1]->shouldNotBe($contact2);
        $this->getContacts()[0]->shouldBe($contact3);
        $this->getContacts()[1]->shouldBe($contact4);

        $this->withContact()->shouldBeAnInstanceOf(Contact::class);
        $this->withContact()->shouldBeAnInstanceOf(Contact::class);
        $this->getContacts()[2]->shouldBeAnInstanceOf(Contact::class);
        $this->getContacts()[3]->shouldBeAnInstanceOf(Contact::class);
    }
}
