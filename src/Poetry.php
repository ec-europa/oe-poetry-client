<?php

namespace EC\Poetry;

use EC\Poetry\Services\Providers\MessagesProvider;
use EC\Poetry\Services\Providers\ParametersProvider;
use EC\Poetry\Services\Providers\ParsersProvider;
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
        $this->register(new ParsersProvider());

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
     * @return \EC\Poetry\Client
     */
    public function getClient()
    {
        return $this['client'];
    }

    /**
     * @return \EC\Poetry\Server
     */
    public function getServer()
    {
        return $this['server'];
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

// @codingStandardsIgnoreStart
/**
 * Callback defined in Poetry WSDL.
 *
 * @param string $user
 * @param string $password
 * @param string $msg
 *
 * @return string
 *    Response in plain XML.
 */
function callback($user, $password, $msg)
{
    $callback = Poetry::getInstance()->raw('server.callback');
    $response = $callback($user, $password, $msg);
    Poetry::getInstance()->getServer()->setResponse($response);

    return $response;
}
// @codingStandardsIgnoreEnd
