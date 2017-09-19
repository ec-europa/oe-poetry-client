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

        // Include namespace-less callback function.
        require_once __DIR__.'/../callback.php';
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
     * Get client WSDL.
     *
     * @return string
     */
    public function getWsdl()
    {
        return $this->getRenderEngine()->render('wsdl', [
            'callback' => $this->get('notification.endpoint'),
        ]);
    }

    /**
     * Get headers to be set by library users when sending WSDL.
     *
     * @return array
     */
    public function getWsdlHeaders()
    {
        return [
          'Content-Type' => 'application/xml; utf-8',
        ];
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
        return $this['soap.server'];
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
