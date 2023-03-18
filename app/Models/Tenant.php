<?php

namespace App\Models;

use App\Integration\CloudFlare as CloudFlareClass;
use App\Integration\Forge\Forge;
use App\Integration\Forge\Site;
use App\Integration\Forge\SSL;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['cloudflare_id', 'username', 'site_id', 'domain', 'aliases', 'directory', 'status', 'deployment_url', 'project_type'];
    protected $casts = [
        'aliases' => 'array',
    ];

    public function cloudflare(): BelongsTo
    {
        return $this->belongsTo(CloudFlare::class);
    }

    public function laravelForge($site = null, $ssl = null): Forge
    {
        $forge = new Forge($site, $ssl, config('forge.clientId'), config('forge.serverId'), config('forge.apiKey'));

        return $forge;
    }

    public function createForgeSite(string $uri): Site
    {
        $site = new Site($uri, $this->domain, $this->project_type, $this->directory, $this->username, $this->aliases, true);
        $forge = $this->laravelForge($site);

        return $forge->createSite('POST');
    }

    public function createSSL(): SSL
    {
        $ssl = new SSL(
            'new',
            $this->domain,
            'US',
            'NY',
            'New York',
            'Company Name',
            'IT',
            '/api/v1/servers/' . config('forge.serverId') . '/sites/' . $this->site_id . '/certificates'
        );
        $forge = $this->laravelForge(null, $ssl);

        return $forge->createSSL('POST');
    }
}
