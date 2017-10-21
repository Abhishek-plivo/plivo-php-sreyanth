<?php

namespace Plivo\Resources\SubAccount;


use Plivo\PlivoClient;
use Plivo\Resources\ResourceList;

/**
 * Class SubAccountList
 * @package Plivo\Resources\SubAccount
 */
class SubAccountList extends ResourceList
{
    /**
     * SubAccountList constructor.
     * @param PlivoClient $plivoClient
     * @param array $meta
     * @param array $resources
     */
    function __construct(PlivoClient $plivoClient, array $meta, array $resources)
    {
        parent::__construct($plivoClient, $meta, $resources);
    }
}