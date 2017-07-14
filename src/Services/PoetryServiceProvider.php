<?php

namespace EC\Poetry\Services;

use EC\Poetry\Server;
use League\Plates\Engine;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Validator\ValidatorBuilder;

/**
 * Class PoetryServiceProvider
 *
 * @package EC\Poetry\Services
 */
class PoetryServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $container)
    {
        $container['renderer.engine.template_folder'] = __DIR__.'/../../templates';

        $container['renderer.engine'] = function (Container $container) {
            $root = $container['renderer.engine.template_folder'];
            $engine = (new Engine($root))
                ->setFileExtension('tpl.php')
                ->addFolder('client', $root.'/client')
                ->addFolder('components', $root.'/components')
                ->addFolder('errors', $root.'/errors')
                ->addFolder('server', $root.'/server');

            return $engine;
        };

        $container['renderer'] = function (Container $container) {
            return new Renderer($container['renderer.engine']);
        };

        $container['validator'] = $container->factory(function (Container $container) {
            return (new ValidatorBuilder())->addMethodMapping('getConstraints')->getValidator();
        });

        $container['server.callback'] = function () {
        };

        $container['server'] = function (Container $container) {
            return new Server($container['server.callback']);
        };
    }
}
