<?php

namespace App\Integration;

use App\Integration\Client;
use GuzzleHttp\Exception\RequestException;

class CloudFlare
{
    protected string $url;
    protected string $email;
    protected string $apiKey;
    protected string $domain;
    protected string $accountID;

    public function __construct(string $url, string $email, string $apiKey, string $domain, string $accountID)
    {
        $this->url($url);
        $this->email($email);
        $this->apiKey($apiKey);
        $this->domain($domain);
        $this->accountID($accountID);
    }

    public function client(): Client
    {
        $client = new Client($this->url);
        return $client;
    }

    public function url(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function email(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function apiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function domain(string $domain): self
    {
        $this->domain = $domain;
        return $this;
    }

    public function accountID(string $accountID): self
    {
        $this->accountID = $accountID;
        return $this;
    }

    public function createSite()
    {
        if ($this->isDomainOrSubDomain() === true) {
            return response()->json([
                'success' => false,
            ], 400);
        }

        try {
            $response = $this->client()->request('POST', 'client/v4/zones', [
                'headers' => [
                    'X-Auth-Email' => $this->email,
                    'X-Auth-Key' => $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'name' => $this->domain,
                    'account' => [
                        'id' => $this->accountID,
                    ],
                ],
            ]);

            return $response;
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    public function isDomainOrSubDomain(): bool
    {
        $domain = explode('.', $this->domain);
        if (count($domain) > 2) {
            return true;
        }
        return false;
    }
}
