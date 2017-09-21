<?php

namespace EC\Poetry\Services\Providers;

use EC\Poetry\NotificationHandler;
use EC\Poetry\Poetry;
use EC\Poetry\Server;
use EC\Poetry\Client;
use EC\Poetry\Services\Plates\AttributesExtension;
use EC\Poetry\Services\Wsdl;
use League\Plates\Engine;
use EC\Poetry\Services\Plates\ComponentExtension;
use EC\Poetry\Services\Renderer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use EC\Poetry\Services\Parser;
use Psr\Log\NullLogger;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Validator\ValidatorBuilder;

/**
 * Class ServicesProvider
 *
 * @package EC\Poetry\Services\Providers
 */
class ServicesProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $container)
    {
        $container['client'] = function (Container $container) {
            return new Client(
                $container['service.username'],
                $container['service.password'],
                $container['client.method'],
                $container['soap_client'],
                $container['validator'],
                $container['renderer'],
                $container['response.status'],
                $container['logger']
            );
        };

        $container['wsdl'] = function (Container $container) {
            return new Wsdl($container['notification.endpoint'], $container['renderer.engine']);
        };

        $container['soap_client'] = function (Container $container) {
            return new \SoapClient($container['service.wsdl'], $container['client.options']);
        };

        $container['notification_handler'] = function (Container $container) {
            return new NotificationHandler(
                $container['notification.username'],
                $container['notification.password'],
                $container['event_dispatcher'],
                $container['parser'],
                $container['response.status']
            );
        };

        $container['soap_server'] = function (Container $container) {
            $wsdl = 'data://text/plain;base64,'.base64_encode($container['wsdl']->getXml());
            $server = new \SoapServer($wsdl, [
                'stream_context' => stream_context_create(),
                'cache_wsdl' => WSDL_CACHE_NONE,
            ]);
            $server->setObject($container['notification_handler']);

            return $server;
        };

        $container['event_dispatcher'] = function () {
            return new EventDispatcher();
        };

        $container['parser'] = $container->factory(function () {
            return new Parser();
        });

        $container['renderer'] = function (Container $container) {
            return new Renderer($container['renderer.engine']);
        };

        $container['renderer.engine'] = function (Container $container) {
            $root = $container['renderer.engine.template_folder'];
            $engine = (new Engine($root))
              ->setFileExtension('tpl.php')
              ->loadExtension(new ComponentExtension())
              ->loadExtension(new AttributesExtension())
              ->addFolder('messages', $root.'/messages')
              ->addFolder('components', $root.'/components');

            return $engine;
        };

        $container['validator'] = $container->factory(function () {
            return (new ValidatorBuilder())->addMethodMapping('getConstraints')->getValidator();
        });

        $container['logger'] = function () {
            return new NullLogger();
        };
    }
}
