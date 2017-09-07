<?php

namespace EC\Poetry\Services\Providers;

use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Requests\CreateRequest;
use EC\Poetry\Messages\Requests\GetRequestStatus;
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
            $component = (new Identifier())
              ->setCode($container['identifier.code'])
              ->setYear($container['identifier.year'])
              ->setNumber($container['identifier.number'])
              ->setVersion($container['identifier.version'])
              ->setPart($container['identifier.part'])
              ->setProduct($container['identifier.product']);

            return $component;
        };

        // Messages.
        $messages = [
          'request.create_request' => CreateRequest::class,
          'request.get_request_status' => GetRequestStatus::class,
        ];
        foreach ($messages as $name => $class) {
            $container[$name] = function (Container $container) use ($class) {
                return new $class($container['component.identifier']);
            };
        }
    }
}
