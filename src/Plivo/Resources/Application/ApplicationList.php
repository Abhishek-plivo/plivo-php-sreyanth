<?php

namespace Plivo\Resources\Application;

use Plivo\PlivoClient;
use Plivo\Resources\ResourceList;

/**
 * Class ApplicationList
 * @package Plivo\Resources\Application
 */
class ApplicationList extends ResourceList
{
    /**
     * ApplicationList constructor.
     * @param PlivoClient $plivoClient
     * @param $meta
     * @param array $resources
     */
    function __construct(PlivoClient $plivoClient, $meta, array $resources)
    {
        parent::__construct($plivoClient, $meta, $resources);
    }
}