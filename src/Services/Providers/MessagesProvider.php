<?php

namespace EC\Poetry\Services\Providers;

use EC\Poetry\Messages\Components as Component;
use EC\Poetry\Messages\Notifications\StatusUpdated;
use EC\Poetry\Messages\Notifications\TranslationReceived;
use EC\Poetry\Messages\ParserAwareInterface;
use EC\Poetry\Messages\Requests\CreateTranslationRequest;
use EC\Poetry\Messages\Requests\GetRequestStatus;
use EC\Poetry\Messages\Requests\GetNewNumber;
use EC\Poetry\Messages\Requests\CreateReviewRequest;
use EC\Poetry\Messages\Responses\Status;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class MessagesProvider
 *
 * @package EC\Poetry\Services
 */
class MessagesProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $container)
    {
        // Identifier component.
        $container['component.identifier'] = $container->factory(function (Container $container) {
            $component = (new Component\Identifier())
              ->setCode($container['settings']['identifier.code'])
              ->setYear($container['settings']['identifier.year'])
              ->setNumber($container['settings']['identifier.number'])
              ->setVersion($container['settings']['identifier.version'])
              ->setPart($container['settings']['identifier.part'])
              ->setSequence($container['settings']['identifier.sequence'])
              ->setProduct($container['settings']['identifier.product']);

            $component->setParser($container['parser']);

            return $component;
        });

        $messages = [
          'component.contact'            => Component\Contact::class,
          'component.details'            => Component\Details::class,
          'component.reference_document' => Component\ReferenceDocument::class,
          'component.return_address'     => Component\ReturnAddress::class,
          'component.source'             => Component\Source::class,
          'component.status'             => Component\Status::class,
          'component.target'             => Component\Target::class,
          'component.source_language'    => Component\SourceLanguage::class,
        ];
        $this->serviceFactory($messages, $container);

        $requests = [
          'request.create_translation_request' => CreateTranslationRequest::class,
          'request.get_request_status'         => GetRequestStatus::class,
          'request.create_review_request'      => CreateReviewRequest::class,
          'request.get_new_number'             => GetNewNumber::class,
        ];
        $this->serviceFactory($requests, $container, $container['component.identifier'], $container['settings']);

        $responses = [
          'response.status' => Status::class,
        ];
        $this->serviceFactory($responses, $container, $container['component.identifier']);
        $this->registerSubscribers($responses, $container);

        $notifications = [
          'notification.translation_received' => TranslationReceived::class,
          'notification.status_updated' => StatusUpdated::class,
        ];
        $this->serviceFactory($notifications, $container, $container['component.identifier']);
        $this->registerSubscribers($notifications, $container);
    }

    /**
     * Helper: Register services.
     *
     * @param array             $services
     * @param \Pimple\Container $container
     * @param array             ...$args
     */
    protected function serviceFactory(array $services, Container $container, ...$args)
    {
        foreach ($services as $name => $class) {
            $container[$name] = $container->factory(function (Container $container) use ($class, $args) {
                $service = (new \ReflectionClass($class))->newInstanceArgs($args);
                if ((new \ReflectionClass($service))->implementsInterface(ParserAwareInterface::class)) {
                    $service->setParser($container['parser']);
                }

                return $service;
            });
        }
    }

    /**
     * @param array $services
     * @param \Pimple\Container $container
     */
    protected function registerSubscribers(array $services, Container $container)
    {
        foreach ($services as $name => $class) {
            $container['event_dispatcher']->addSubscriber($container[$name]);
        }
    }
}
