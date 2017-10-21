<?php

namespace Plivo\Resources;


use Plivo\Exceptions\PlivoRestException;
use Plivo\PlivoClient;

/**
 * Class Resource
 * @package Plivo\Resources
 */
class Resource
{
    /**
     * @var PlivoClient
     */
    protected $client;

    /**
     * @var ResourceInterface
     */
    protected $interface = null;

    /**
     * @var null
     */
    protected $id = null;

    /**
     * @var array
     */
    protected $pathParams = [];

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * Resource constructor.
     * @param PlivoClient $client
     */
    function __construct(PlivoClient $client)
    {
        $this->client = $client;
    }

    /**
     * Lazy getter to get the properties by name
     * @param $name
     * @return mixed
     * @throws PlivoRestException
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        throw new PlivoRestException('Resource does not contain ' . $name);
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }



}