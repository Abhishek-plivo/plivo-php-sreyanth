<?php

namespace Plivo\Resources;


use Plivo\PlivoClient;

/**
 * Class ResourceList
 * @package Plivo\Resources
 */
class ResourceList implements \IteratorAggregate
{
    /**
     * @var PlivoClient
     */
    protected $client;

    /**
     * @var array
     */
    protected $pathParams = [];

    /**
     * @var
     */
    protected $uri;

    /**
     * @var
     */
    protected $meta;

    /**
     * @var array
     */
    protected $resources;

    /**
     * ResourceList constructor.
     * @param PlivoClient $plivoClient
     * @param $meta
     * @param array $resources
     */
    function __construct(PlivoClient $plivoClient, array $meta, array $resources)
    {
        $this->client = $plivoClient;
        $this->meta = $meta;
        $this->resources = $resources;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->resources);
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->resources;
    }
}