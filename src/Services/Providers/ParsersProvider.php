<?php

namespace EC\Poetry\Services\Providers;

use EC\Poetry\Parsers\Components as Component;
use EC\Poetry\Parsers as Message;
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
        // Component parsers.
        $components = [
          'identifier' => Component\IdentifierParser::class,
          'status' => Component\StatusComponentParser::class,
          'contact' => Component\ContactParser::class,
          'details' => Component\DetailsParser::class,
          'referenceDocument' => Component\ReferenceDocumentParser::class,
          'source' => Component\SourceParser::class,
          'target' => Component\TargetParser::class,
          'returnAddress' => Component\ReturnAddressParser::class,
        ];
        foreach ($components as $name => $class) {
            $container['parser.component.'.$name] = function (Container $container) use ($class) {
                return new $class($container['crawler'], $container);
            };
        }

        // Message parsers.
        $messages = [
          'request' => Message\RequestParser::class,
          'status' => Message\StatusParser::class,
        ];
        foreach ($messages as $name => $class) {
            $container['parser.message.'.$name] = function (Container $container) use ($class) {
                return new $class($container['crawler'], $container);
            };
        }
    }
}
