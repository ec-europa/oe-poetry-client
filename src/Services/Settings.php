<?php

namespace EC\Poetry\Services;

/**
 * Class Settings
 *
 * @package EC\Poetry\Services
 */
class Settings implements \ArrayAccess
{
    /**
     * @var array
     */
    protected $settings = [
        // Default Identifier values.
      'identifier.code' => '',
      'identifier.year' => '',
      'identifier.number' => '',
      'identifier.version' => '',
      'identifier.sequence' => '',
      'identifier.part' => '',
      'identifier.product' => '',

        // Service credentials.
      'service.wsdl' => '',
      'service.username' => '',
      'service.password' => '',

        // Client service parameters.
      'client.wsdl' => '',
      'client.options' => [
        'cache_wsdl' => WSDL_CACHE_NONE,
      ],

        // Notification parameters.
      'notification.endpoint' => '',
      'notification.username' => '',
      'notification.password' => '',
    ];

    /**
     * @param string $name
     *
     * @return mixed|string
     */
    public function get($name)
    {
        return isset($name) ? $this->settings[$name] : '';
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    public function set($name, $value)
    {
        $this->settings[$name] = $value;

        return $this;
    }

    /**
     * @param array $values
     */
    public function withArray(array $values)
    {
        foreach ($values as $name => $value) {
            $this->set($name, $values);
        }
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->settings);
    }

    /**
     * Get Settings property.
     *
     * @return array
     *   Property value.
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->settings[$offset]);
    }
}
