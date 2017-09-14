<?php

namespace EC\Poetry\Services\Providers;

use EC\Poetry\Messages\Components as Component;
use EC\Poetry\Messages\ParserAwareInterface;
use EC\Poetry\Messages\Requests\CreateRequest;
use EC\Poetry\Messages\Requests\GetRequestStatus;
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
        $container['component.identifier'] = function (Container $container) {
            $component = (new Component\Identifier())
                ->setCode($container['identifier.code'])
                ->setYear($container['identifier.year'])
                ->setNumber($container['identifier.number'])
                ->setVersion($container['identifier.version'])
                ->setPart($container['identifier.part'])
                ->setProduct($container['identifier.product']);

            $component->setParser($container['parser']);

            return $component;
        };

        $components = [
            'component.attribution'         => Component\Attribution::class,
            'component.contact'             => Component\Contact::class,
            'component.details'             => Component\Details::class,
            'component.reference_document'  => Component\ReferenceDocument::class,
            'component.return_address'      => Component\ReturnAddress::class,
            'component.source'              => Component\Source::class,
            'component.status'              => Component\Status::class,
            'component.target'              => Component\Target::class,
        ];
        $this->registerServices($components, $container);

        // Messages.
        $messages = [
            // Request objects.
            'request.create_request'        => CreateRequest::class,
            'request.get_request_status'    => GetRequestStatus::class,
            'request.send_review_request'   => SendReviewRequest::class,

            // Response objects.
            'response.status'               => Status::class,
        ];
        $this->registerServices($messages, $container);
    }

    /**
     * Helper: Register services.
     *
     * @param array $services
     *      List of services.
     * @param $container
     *      Container object.
     */
    protected function registerServices(array $services, &$container)
    {
        foreach ($services as $name => $class) {
            $container[$name] = function (Container $container) use ($class) {
                $service = new $class($container['component.identifier']);
                if ((new \ReflectionClass($service))->implementsInterface(ParserAwareInterface::class)) {
                    $service->setParser($container['parser']);
                }

                return $service;
            };
        }
    }
}
