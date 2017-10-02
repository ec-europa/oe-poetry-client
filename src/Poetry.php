<?php

namespace EC\Poetry;

use EC\Poetry\Services\Providers\MessagesProvider;
use EC\Poetry\Services\Providers\ParametersProvider;
use EC\Poetry\Services\Providers\ServicesProvider;
use Pimple\Container;
use Psr\Container\ContainerInterface;

/**
 * Class Poetry
 *
 * @package Poetry
 */
class Poetry extends Container implements ContainerInterface
{
    /**
     * @var \EC\Poetry\Poetry
     */
    static private $container = null;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

        // Register services.
        $this->register(new ParametersProvider());
        $this->register(new ServicesProvider());
        $this->register(new MessagesProvider());

        // Override container values.
        foreach ($values as $name => $value) {
            $this->offsetSet($name, $value);
        }

        // Set static cache.
        self::$container = $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        return $this[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        return $this->offsetExists($name);
    }

    /**
     * @return \EC\Poetry\Messages\Components\Identifier
     */
    public function getIdentifier()
    {
        return $this['component.identifier'];
    }

    /**
     * @return \EC\Poetry\Client
     */
    public function getClient()
    {
        return $this['client'];
    }

    /**
     * @return \SoapServer
     */
    public function getServer()
    {
        return $this['soap_server'];
    }

    /**
     * @return \EC\Poetry\Services\Renderer
     */
    public function getRenderer()
    {
        return $this['renderer'];
    }

    /**
     * @return \League\Plates\Engine
     */
    public function getRenderEngine()
    {
        return $this['renderer.engine'];
    }

    /**
     * @return \Symfony\Component\Validator\Validator\RecursiveValidator
     */
    public function getValidator()
    {
        return $this['validator'];
    }

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger()
    {
        return $this['logger'];
    }

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    public function getEventDispatcher()
    {
        return $this['event_dispatcher'];
    }

    /**
     * Get WSDL service.
     *
     * @return \EC\Poetry\Services\Wsdl
     */
    public function getWsdl()
    {
        return $this['wsdl'];
    }

    /**
     * @return \EC\Poetry\Poetry
     */
    public static function getInstance()
    {
        if (empty(self::$container)) {
            new self();
        }

        return self::$container;
    }
}
