<?php

namespace EC\Poetry\Messages\Notifications;

use EC\Poetry\Events\ExceptionEvent;
use EC\Poetry\Events\Notifications\StatusUpdatedEvent;
use EC\Poetry\Events\ParseNotificationEvent;
use EC\Poetry\Exceptions\ValidationException;
use EC\Poetry\Messages\Components\Status;
use EC\Poetry\Messages\Traits\WithStatusTrait;
use EC\Poetry\Messages\Traits\WithTargetsTrait;
use EC\Poetry\Poetry;
use EC\Poetry\Services\Parser;
use EC\Poetry\Traits\DispatchExceptionEventTrait;

/**
 * Class StatusUpdated
 *
 * @package EC\Poetry\Messages\Notifications
 */
class StatusUpdated extends AbstractNotification
{
    use WithStatusTrait;
    use WithTargetsTrait;
    use DispatchExceptionEventTrait;

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'notifications::status';
    }

    /**
     * {@inheritdoc}
     */
    public function onParseNotification(ParseNotificationEvent $event)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($event->getXml());
        if ('status' === $parser->getAttribute('POETRY/request', 'type')) {
            $this->fromXml($event->getXml());

            $response = $this->generateResponse();
            $status = new Status();
            $status->setType('request')
              ->setTime('')
              ->setDate('');
            $poetry = new Poetry();
            $violations = $poetry->getValidator()->validate($this);
            if ($violations->count() > 0) {
                $event->setEvent(new ExceptionEvent(new ValidationException($violations), $this));
                $this->dispatchExceptionEvent(new ValidationException($violations));
                $status->setCode('-1')
                  ->setMessage('');
            } else {
                $event->setEvent(new StatusUpdatedEvent($this));
                $status->setCode('-1')
                  ->setMessage('');
            }
            $response->addStatus($status);
            $event->stopPropagation();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function parseXml($xml)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($xml);

        $xml = $parser->getOuterContent('POETRY/request/demandeId');
        $this->getIdentifier()->fromXml($xml);

        $this->setMessageId($parser->getAttribute('POETRY/request', 'id'));

        $parser->eachComponent("POETRY/request/status", function (Parser $component) {
            $this->withStatus()
              ->setParser($this->getParser())
              ->fromXml($component->outerHtml());
        }, $this);

        $parser->eachComponent("POETRY/request/attributions", function (Parser $component) {
            $this->withTarget()
              ->setParser($this->getParser())
              ->fromXml($component->outerHtml());
        }, $this);

        return $this;
    }
}
