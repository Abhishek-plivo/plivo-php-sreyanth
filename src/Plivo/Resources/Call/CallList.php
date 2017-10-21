<?php

namespace Plivo\Resources\Call;


use Plivo\PlivoClient;
use Plivo\Resources\ResourceList;

/**
 * Class CallList
 * @package Plivo\Resources\Call
 */
class CallList extends ResourceList
{

    /**
     * CallList constructor.
     * @param PlivoClient $plivoClient
     * @param array $meta
     * @param array $resources
     */
    function __construct(PlivoClient $plivoClient, $meta, array $resources)
    {
        parent::__construct($plivoClient, $meta, $resources);
    }

}