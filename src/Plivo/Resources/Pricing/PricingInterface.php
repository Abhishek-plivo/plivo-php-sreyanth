<?php

namespace Plivo\Resources\Pricing;


use Plivo\PlivoClient;
use Plivo\Resources\ResourceInterface;

/**
 * Class PricingInterface
 * @package Plivo\Resources\Pricing
 */
class PricingInterface extends ResourceInterface
{
    /**
     * PricingInterface constructor.
     * @param PlivoClient $plivoClient
     * @param $authId
     */
    function __construct(PlivoClient $plivoClient, $authId)
    {
        parent::__construct($plivoClient);

        $this->pathParams = [
            'authId' => $authId
        ];

        $this->uri = "Account/".$authId."/Pricing/";
    }

    /**
     * Return pricing for a country ISO
     * @param $countryIso
     * @return Pricing
     */
    public function get($countryIso)
    {
        $response = $this->client->fetch(
            $this->uri,
            ['country_iso' => $countryIso]
        );

        return new Pricing(
            $this->client, $response->getContent());
    }

}