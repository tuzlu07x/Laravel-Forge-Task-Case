<?php

namespace App\Integration;

class Forge
{
    protected string $clientId;
    protected string $serverId;
    protected string $apiKey;

    public function __construct(string $clientId, string $serverId, string $apiKey)
    {
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
}
