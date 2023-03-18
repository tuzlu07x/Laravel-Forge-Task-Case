<?php

namespace App\Models;

use App\Integration\CloudFlare as CloudFlareClass;
use App\Integration\Forge\Forge;
use App\Integration\Forge\Site;
use App\Integration\Forge\SSL;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tenant extends Model
{
    use HasFactory;
    protected $fillable = ['cloudflare_id', 'site_id', 'project_name', 'domain', 'subdomain'];

    public function cloudflare(): BelongsTo
    {
        return $this->belongsTo(CloudFlare::class);
    }

    public function createCloudflare(): array
    {
        $classCloudFlare = new CloudFlareClass(config('cloudflare.url'), config('cloudflare.email'), config('cloudflare.apiKey'), config('cloudflare.accountId'));

        if (!$this->subdomain) {
            $data = $classCloudFlare->createSite($this->domain);
        } else {
            $data = $classCloudFlare->createSubdomain($this->domain, $this->subdomain);
        }

        if (isset($data->errors)) {
            return $data->errors;
        }

        $model = CloudFlare::create([
            'domain' => $data['result']['name'],
            'status' => $data['result']['status'],
            'name_servers' => $data['result']['name_servers'],
            'success' => $data['success'],
        ]);
        $this->update(['cloudflare_id' => $model->id]);
    }

    public function laravelForge($site = null, $ssl = null): Forge
    {
        $forge = new Forge($site, $ssl, config('forge.clientId'), config('forge.serverId'), config('forge.apiKey'));

        return $forge;
    }

    public function createForgeSite(): Site
    {

        $site = new Site(config('forge.serverId'), $this->domain, 'php', '/home/forge/fatihtuzlu.org', $this->project_name, ['tuzlu.org'], true);
        $forge = $this->laravelForge($site);
        $response = $forge->createSite('POST');
        $this->update(['site_id' => $response['site']['id']]);

        return $response;
    }

    public function createSSL(): SSL
    {
        $ssl = new SSL('new', $this->domain, 'US', 'NY', 'New York', 'Company Name', 'IT', $this->site_id, config('forge.serverId'));
        $forge = $this->laravelForge(null, $ssl);

        return $forge->createSSL($this->domain);
    }
}
