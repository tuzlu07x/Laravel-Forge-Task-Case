<?php

namespace App\Integration\Forge;

use App\Integration\Client;

class Site
{
    protected string $phpVersion = 'php82';
    protected string $domain;
    protected string $uri;
    protected string $projectType;
    protected string $directory;
    protected string $username;
    protected string $database = "";
    protected int $nginxTemplate = 1;
    protected array $aliases;
    protected bool $isolated;

    public function __construct(string $uri, string $domain, string $protectType, string $directory, string $username, array $aliases, bool $isolated)
    {
        $this->uri($uri);
        $this->domain($domain);
        $this->projectType($protectType);
        $this->directory($directory);
        $this->username($username);
        $this->aliases($aliases);
        $this->isolated($isolated);
    }

    public function uri(string $uri): self
    {
        $this->uri = $uri;
        return $this;
    }

    public function domain(string $domain): self
    {
        $this->domain = $domain;
        return $this;
    }

    public function projectType(string $projectType): self
    {
        $this->projectType = $projectType;
        return $this;
    }

    public function directory(string $directory): self
    {
        $this->directory = $directory;
        return $this;
    }

    public function username(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function database(string $database): self
    {
        $this->database = $database;
        return $this;
    }

    public function aliases(array $aliases): self
    {
        $this->aliases = $aliases;
        return $this;
    }

    public function isolated(bool $isolated): self
    {
        $this->isolated = $isolated;
        return $this;
    }

    public function create(): array
    {
        return [
            "domain" => $this->domain,
            "project_type" => $this->projectType,
            "aliases" => $this->aliases,
            "directory" => $this->directory,
            "isolated" => $this->isolated,
            "username" => $this->username,
            "database" => $this->database,
            "php_version" => $this->phpVersion,
            //"nginx_template" => $this->nginxTemplate,
        ];
    }

    public function client(string $baseUrl): Client
    {
        return new Client($baseUrl);
    }

    public function request(string $method)
    {
        $client = $this->client(config('forge.baseUrl'))->request($method, $this->uri, [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . config('forge.apiKey'),
            ],
            'json' => $this->create(),
        ]);

        return $client;
    }
}
