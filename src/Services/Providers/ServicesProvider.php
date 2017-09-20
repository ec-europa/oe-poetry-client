<?php

namespace EC\Poetry\Services\Providers;

use EC\Poetry\Server;
use EC\Poetry\Client;
use EC\Poetry\Services\Plates\AttributesExtension;
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
        $container['renderer.engine'] = function (Container $container) {
            $root = $container['renderer.engine.template_folder'];
            $engine = (new Engine($root))
                ->setFileExtension('tpl.php')
                ->loadExtension(new ComponentExtension())
                ->loadExtension(new AttributesExtension())
                ->addFolder('messages', $root.'/messages')
                ->addFolder('components', $root.'/components')
                ->addFolder('server', $root.'/server');

            return $engine;
        };

        $container['renderer'] = function (Container $container) {
            return new Renderer($container['renderer.engine']);
        };

        $container['validator'] = $container->factory(function () {
            return (new ValidatorBuilder())->addMethodMapping('getConstraints')->getValidator();
        });

        $container['client'] = function (Container $container) {
            return new Client(
                $container['service.username'],
                $container['service.password'],
                $container['client.method'],
                $container['soap.client'],
                $container['validator'],
                $container['renderer'],
                $container['response.status'],
                $container['logger']
            );
        };

        $container['soap.client'] = function (Container $container) {
            return new \SoapClient($container['service.wsdl'], $container['client.options']);
        };

        $container['parser'] = $container->factory(function () {
            return new Parser();
        });

        $container['soap.server'] = function (Container $container) {
            $wsdl = 'data://text/plain;base64,'.base64_encode($container->renderClientWsdl());
            $server = new \SoapServer($wsdl, [
                'stream_context' => stream_context_create(),
                'cache_wsdl' => WSDL_CACHE_NONE,
            ]);
            $server->addFunction("OEPoetryCallback");

            return $server;
        };

        $container['event_dispatcher'] = function () {
            return new EventDispatcher();
        };

        $container['logger'] = function () {
            return new NullLogger();
        };
    }
}
