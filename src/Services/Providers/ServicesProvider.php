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
use EC\Poetry\Services\Crawler;
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

        $container['validator'] = $container->factory(function (Container $container) {
            return (new ValidatorBuilder())->addMethodMapping('getConstraints')->getValidator();
        });

        $container['client'] = function (Container $container) {
            return new Client($container['authentication.username'], $container['authentication.password'], $container['client.method'], $container['soap.client'], $container['validator'], $container['renderer']);
        };

        $container['soap.client'] = function (Container $container) {
            return new \SoapClient($container['client.wsdl'], $container['client.options']);
        };

        $container['crawler'] = $container->factory(function (Container $container) {
            return new Crawler();
        });

        $container['soap.server'] = function (Container $container) {
            $wsdl = $container['renderer.engine']->render('server::callback', ['uri' => $container['server.uri']]);
            $file = 'data://text/plain;base64,'.base64_encode($wsdl);
            $server = new \SoapServer($file, $container['server.options']);
            $server->AddFunction("EC\Poetry\callback");

            return $server;
        };
        $container['server'] = function (Container $container) {
            return new Server($container['soap.server'], []);
        };
    }
}
