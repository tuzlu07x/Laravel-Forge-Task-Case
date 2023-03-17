<?php

namespace App\Integration\Forge;

use GuzzleHttp\Exception\RequestException;

class Forge
{
    protected ?Site $site;
    protected string $clientId;
    protected string $serverId;
    protected string $apiKey;

    public function __construct(Site $site, string $clientId, string $serverId, string $apiKey)
    {
        $this->site = $site;
        $this->clientId($clientId);
        $this->serverId($serverId);
        $this->apiKey($apiKey);
    }

    private function clientId(string $clientId): void
    {
        $this->clientId = $clientId;
    }

    private function serverId(string $serverId): void
    {
        $this->serverId = $serverId;
    }

    private function apiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    public function site(): Site
    {
        return $this->site;
    }

    public function createSite(string $method)
    {
        try {
            $response = $this->site->request($method);
            return $response;
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }
}
