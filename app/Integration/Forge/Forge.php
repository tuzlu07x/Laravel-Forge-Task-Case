<?php

namespace App\Integration\Forge;

use GuzzleHttp\Exception\RequestException;

class Forge
{
    protected ?Site $site = null;
    protected ?SSL $ssl = null;
    protected string $clientId;
    protected string $serverId;
    protected string $apiKey;

    public function __construct(Site $site = null, SSL $ssl = null, string $clientId, string $serverId, string $apiKey)
    {
        $this->site = $site;
        $this->ssl = $ssl;
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

    public function ssl(): SSL
    {
        return $this->ssl;
    }

    public function createSite()
    {
        $response = $this->site->request();
        return $response;
    }

    public function createSSL(string $domain)
    {
        $response = $this->ssl->request($domain);
        return $response;
    }

    public function listSSL()
    {
        $response = $this->ssl->getSsl();
        return $response;
    }
}
