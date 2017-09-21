<?php

namespace EC\Poetry\Services;

use League\Plates\Engine;

/**
 * Class Wsdl
 *
 * @package EC\Poetry\Services
 */
class Wsdl
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var \League\Plates\Engine
     */
    protected $renderEngine;

    /**
     * @var array
     */
    protected $headers = [
      'content-type' => 'application/xml; utf-8',
    ];

    /**
     * Wsdl constructor.
     *
     * @param string                $url
     * @param \League\Plates\Engine $renderEngine
     */
    public function __construct($url, Engine $renderEngine)
    {
        $this->url = $url;
        $this->renderEngine = $renderEngine;
    }

    /**
     * Get client WSDL XML.
     *
     * @return string
     */
    public function getXml()
    {
        return $this->renderEngine->render('wsdl', ['callback' => $this->url]);
    }

    /**
     * Get headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Send HTTP headers for WSDL response.
     */
    public function sendHeaders()
    {
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
    }
}
