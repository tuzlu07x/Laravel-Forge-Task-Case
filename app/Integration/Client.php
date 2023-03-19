<?php

namespace App\Integration;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

class Client
{
    protected string $url;
    protected ?GuzzleClient $client = null;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function url(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function client(): GuzzleClient
    {
        if (!$this->client) {
            $this->client = new GuzzleClient([
                'base_uri' => $this->url,
            ]);
        }

        return $this->client;
    }

    public function request(string $method, string $uri, array $options = [])
    {
        try {
            $response = $this->client()->request($method, $uri, $options);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }
}
