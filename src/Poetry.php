<?php

namespace EC\Poetry;

use EC\Poetry\Services\PoetryServiceProvider;
use EC\Poetry\Services\Providers\MessagesProvider;
use EC\Poetry\Services\Providers\ParametersProvider;
use EC\Poetry\Services\Providers\ParsersProvider;
use EC\Poetry\Services\Providers\ServicesProvider;
use Pimple\Container;

/**
 * Class Poetry
 *
 * @package Poetry
 */
class Poetry extends Container
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

        // Require SOAP global callback function.
        require_once __DIR__.'/../callback.php';
    }

    /**
     * Return service object or parameter value.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function get($name)
    {
        return $this[$name];
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
