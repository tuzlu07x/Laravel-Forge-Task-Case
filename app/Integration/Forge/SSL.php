<?php

namespace App\Integration\Forge;

use App\Integration\Client;

class SSL
{
    protected Client $client;
    protected string $type;
    protected string $country;
    protected string $state;
    protected string $city;
    protected string $organization;
    protected string $department;
    protected string $siteId;
    protected string $serverId;

    public function __construct(string $type, string $country, string $state, string $city, string $organization, string $department, $siteId, $serverId)
    {
        $this->type($type);
        $this->country($country);
        $this->state($state);
        $this->city($city);
        $this->organization($organization);
        $this->department($department);
        $this->siteId = $siteId;
        $this->serverId = $serverId;
    }

    public function client(string $baseUrl): Client
    {
        return new Client($baseUrl);
    }


    public function type(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function country(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function state(string $state): self
    {
        $this->state = $state;
        return $this;
    }


    public function city(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function organization(string $organization): self
    {
        $this->organization = $organization;
        return $this;
    }

    public function department(string $department): self
    {
        $this->department = $department;
        return $this;
    }

    public function create(string $domain): array
    {
        return [
            'type' => $this->type,
            'domain' => $domain,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'organization' => $this->organization,
            'department' => $this->department,
        ];
    }

    public function request(string $domain)
    {
        $client = $this->client(config('forge.baseUrl'))->request('POST', '/api/v1/servers/' . $this->serverId . '/sites/' . $this->siteId . '/certificates', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . config('forge.apiKey'),
            ],
            'json' => $this->create($domain)
        ]);

        return $client;
    }


    public function getSsl()
    {
        $client = $this->client(config('forge.baseUrl'))->request('GET', '/api/v1/servers/' . $this->serverId . '/sites/' . $this->siteId . '/certificates', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . config('forge.apiKey'),
            ],
        ]);

        return $client;
    }
}
