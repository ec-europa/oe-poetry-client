<?php

namespace EC\Poetry\Services\Providers;

use EC\Poetry\Messages\Client;
use EC\Poetry\Messages\Components\Identifier;
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
            $identifier = $container['identifier'];
            $component = (new Identifier())
              ->setCode($identifier['code'])
              ->setYear($identifier['year'])
              ->setNumber($identifier['number'])
              ->setVersion($identifier['version'])
              ->setPart($identifier['part'])
              ->setProduct($identifier['product']);

            return $component;
        };

        // Messages.
        $messages = [
          'client.get_status' => Client\GetStatus::class,
        ];
        foreach ($messages as $name => $class) {
            $container['message.'.$name] = function (Container $container) use ($class) {
                return new $class($container['component.identifier']);
            };
        }
    }
}
