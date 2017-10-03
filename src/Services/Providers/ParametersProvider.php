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
        $container['identifier.sequence'] = '';
        $container['identifier.part'] = '';
        $container['identifier.product'] = '';

        // Service credentials.
        $container['service.wsdl'] = '';
        $container['service.username'] = '';
        $container['service.password'] = '';

        // Client service parameters.
        $container['client.wsdl'] = '';
        $container['client.options'] = [
          'cache_wsdl' => WSDL_CACHE_NONE,
        ];

        // Notification parameters.
        $container['notification.endpoint'] = '';
        $container['notification.username'] = '';
        $container['notification.password'] = '';

        // Render engine parameters.
        $container['renderer.engine.template_folder'] = __DIR__.'/../../../templates';
    }
}
