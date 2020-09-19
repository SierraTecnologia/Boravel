<?php

namespace Boravel;

use GuzzleHttp\Client;
use Boravel\Traits\Actions\ManagesBrokenLinks;
use Boravel\Traits\Actions\ManagesCertificateHealth;
use Boravel\Traits\Actions\ManagesChecks;
use Boravel\Traits\Actions\ManagesDowntime;
use Boravel\Traits\Actions\ManagesMaintenancePeriods;
use Boravel\Traits\Actions\ManagesMixedContent;
use Boravel\Traits\Actions\ManagesSites;
use Boravel\Traits\Actions\ManagesStatusPages;
use Boravel\Traits\Actions\ManagesUptime;
use Boravel\Traits\Actions\ManagesUsers;

class BoravelNetworking
{
    use MakesHttpRequests,
        ManagesSites,
        ManagesChecks,
        ManagesUsers,
        ManagesBrokenLinks,
        ManagesMaintenancePeriods,
        ManagesMixedContent,
        ManagesUptime,
        ManagesDowntime,
        ManagesCertificateHealth,
        ManagesStatusPages;

    /**
     * @var string 
     */
    public $apiToken;

    /**
     * @var \GuzzleHttp\Client 
     */
    public $client;

    public function __construct(string $apiToken, Client $client = null)
    {
        $this->apiToken = $apiToken;

        $this->client = $client ?: new Client(
            [
            'base_uri' => 'https://boravel.app/api/',
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'Bearer '.$this->apiToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            ]
        );
    }

    protected function transformCollection(array $collection, string $class): array
    {
        return array_map(
            function ($attributes) use ($class) {
                return new $class($attributes, $this);
            }, $collection
        );
    }
}
