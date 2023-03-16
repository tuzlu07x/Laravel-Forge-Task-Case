<?php

namespace App\Integration;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

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

    public function request(string $method, string $uri, array $options = []): array
    {
        $response = $this->client()->request($method, $uri, $options);
        $this->handleRequestError($response);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function handleRequestError(ResponseInterface $response): void
    {
        if ($response->getStatusCode() === 400) {
            throw new \Exception('Valid data was given but the request has failed.');
        }
        if ($response->getStatusCode() === 401) {
            throw new \Exception('No valid API Key was given.');
        }
        if ($response->getStatusCode() === 404) {
            throw new \Exception('The request resource could not be found.');
        }
        if ($response->getStatusCode() === 422) {
            throw new \Exception('The payload has missing required parameters or invalid data was given.');
        }
        if ($response->getStatusCode() === 429) {
            throw new \Exception('Too many attempts.');
        }

        throw new \Exception('Something went wrong.');
    }
}
