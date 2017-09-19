<?php

namespace EC\Poetry\Services\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ParametersProvider
 *
 * @package EC\Poetry\Services
 */
class ParametersProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $container)
    {
        // Default Identifier values.
        $container['identifier.code'] = '';
        $container['identifier.year'] = '';
        $container['identifier.number'] = '';
        $container['identifier.version'] = '';
        $container['identifier.part'] = '';
        $container['identifier.product'] = '';

        // Authentication credentials.
        $container['authentication.username'] = '';
        $container['authentication.password'] = '';

        // Client service parameters.
        $container['service.wsdl'] = '';
        $container['client.method'] = 'requestService';
        $container['client.options'] = [
          'cache_wsdl' => WSDL_CACHE_NONE,
        ];

        $container['client.wsdl'] = '';
        $container['notification.endpoint'] = '';

        // Server parameters.
        $container['server.uri'] = '';
        $container['server.callback'] = function () {
        };
        $container['server.options'] = [
          'stream_context' => stream_context_create(),
          'cache_wsdl' => WSDL_CACHE_NONE,
        ];

        // Render engine parameters.
        $container['renderer.engine.template_folder'] = __DIR__.'/../../../templates';
    }
}
