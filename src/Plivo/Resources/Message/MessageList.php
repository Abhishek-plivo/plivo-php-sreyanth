<?php

namespace Plivo\Resources\Message;


use Plivo\PlivoClient;
use Plivo\Resources\ResourceList;

/**
 * Class MessageList
 * @package Plivo\Resources\Message
 */
class MessageList extends ResourceList
{

    /**
     * MessageList constructor.
     * @param PlivoClient $plivoClient
     * @param $meta
     * @param array $resources
     */
    function __construct(PlivoClient $plivoClient, $meta, array $resources)
    {
        parent::__construct($plivoClient, $meta, $resources);
    }
}