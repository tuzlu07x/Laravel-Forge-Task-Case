<?php

namespace App\Integration\Forge;

use App\Integration\Client;

class SSL
{
    protected Client $client;
    protected string $type;
    protected string $domain;
    protected string $country;
    protected string $state;
    protected string $city;
    protected string $organization;
    protected string $department;
    protected string $uri;

    public function __construct(string $type, string $domain, string $country, string $state, string $city, string $organization, string $department, string $uri)
    {
        $this->type($type);
        $this->domain($domain);
        $this->country($country);
        $this->state($state);
        $this->city($city);
        $this->organization($organization);
        $this->department($department);
        $this->uri($uri);
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

    public function domain(string $domain): self
    {
        $this->domain = $domain;
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

    public function uri(string $uri): self
    {
        $this->uri = $uri;
        return $this;
    }

    public function create(): array
    {
        return [
            'type' => $this->type,
            'domain' => $this->domain,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'organization' => $this->organization,
            'department' => $this->department,
        ];
    }

    public function request(string $method)
    {
        $client = $this->client(config('forge.baseUrl'))->request($method, $this->uri, [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . config('forge.apiKey'),
            ],
            'json' => $this->create()
        ]);

        return $client;
    }
}
