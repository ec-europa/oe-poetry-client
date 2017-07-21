<?php

namespace EC\Poetry\Services\Providers;

use EC\Poetry\Services\Parsers\Components\IdentifierParser;
use EC\Poetry\Services\Parsers\Components\StatusParser;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ParsersProvider
 *
 * @package EC\Poetry\Services\Providers
 */
class ParsersProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $container)
    {
        // Parsers.
        $messages = [
          'identifier' => IdentifierParser::class,
          'status' => StatusParser::class,
        ];
        foreach ($messages as $name => $class) {
            $container['parser.'.$name] = function (Container $container) use ($class) {
                return new $class($container['crawler']);
            };
        }
    }
}
