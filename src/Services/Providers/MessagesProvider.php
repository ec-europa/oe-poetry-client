<?php

namespace EC\Poetry\Services\Providers;

use EC\Poetry\Messages\Components as Component;
use EC\Poetry\Messages\Notifications\TranslationReceived;
use EC\Poetry\Messages\ParserAwareInterface;
use EC\Poetry\Messages\Requests\CreateRequest;
use EC\Poetry\Messages\Requests\GetRequestStatus;
use EC\Poetry\Messages\Requests\RequestNewNumber;
use EC\Poetry\Messages\Requests\SendReviewRequest;
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
        // Default Identifier values.
        $container['identifier'] = [
            'code' => '',
            'year' => '',
            'number' => '',
            'version' => '',
            'part' => '',
            'product' => '',
        ];

        // Identifier component.
        $container['component.identifier'] = $container->factory(function (Container $container) {
            $component = (new Component\Identifier())
                ->setCode($container['identifier.code'])
                ->setYear($container['identifier.year'])
                ->setNumber($container['identifier.number'])
                ->setVersion($container['identifier.version'])
                ->setPart($container['identifier.part'])
                ->setSequence($container['identifier.sequence'])
                ->setProduct($container['identifier.product']);

            $component->setParser($container['parser']);

            return $component;
        });

        $messages = [
            'component.contact'             => Component\Contact::class,
            'component.details'             => Component\Details::class,
            'component.reference_document'  => Component\ReferenceDocument::class,
            'component.return_address'      => Component\ReturnAddress::class,
            'component.source'              => Component\Source::class,
            'component.status'              => Component\Status::class,
            'component.target'              => Component\Target::class,
        ];
        $this->serviceFactory($messages, $container);

        $requests = [
            // Request objects.
            'request.create_request'            => CreateRequest::class,
            'request.get_request_status'        => GetRequestStatus::class,
            'request.send_review_request'       => SendReviewRequest::class,
            'request.request_new_number'        => RequestNewNumber::class,

            // Response objects.
            'response.status'                   => Status::class,

            // Notification objects.
            'notification.translation_received' => TranslationReceived::class,
        ];
        $this->serviceFactory($requests, $container);

        $responses = [
            'response.status'                   => Status::class,
        ];
        $this->serviceFactory($responses, $container);
        $this->registerSubscribers($responses, $container);

        $notifications = [
          'notification.translation_received' => TranslationReceived::class,
        ];
        $this->serviceFactory($notifications, $container);
//        $this->registerSubscribers($notifications, $container);
    }

    /**
     * Helper: Register services.
     *
     * @param array $services
     *      List of services.
     * @param \Pimple\Container $container
     *      Container object.
     */
    protected function serviceFactory(array $services, Container $container)
    {
        foreach ($services as $name => $class) {
            $container[$name] = $container->factory(function (Container $container) use ($class) {
                $service = new $class($container['component.identifier']);
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
