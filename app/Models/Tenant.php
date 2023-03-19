<?php

namespace App\Models;

use App\Integration\Forge\Forge;
use App\Integration\Forge\SSL;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Tenant extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = ['cloudflare_id', 'site_id', 'project_name', 'domain', 'subdomain', 'forge_status', 'cloudflare_status', 'ssl_status', 'cloudflare_zone_id'];

    public function cloudflare(): BelongsTo
    {
        return $this->belongsTo(CloudFlare::class);
    }

    public function laravelForge($site = null, $ssl = null)
    {
        $forge = new Forge($site, $ssl, config('forge.clientId'), config('forge.serverId'), config('forge.apiKey'));

        return $forge;
    }

    public function createSSL()
    {
        $ssl = new SSL('new', 'USA', 'NY', 'New York', 'Company Name', 'IT', $this->site_id, config('forge.serverId'));
        $forge = $this->laravelForge(null, $ssl);

        return $forge->createSSL($this->domain);
    }
}
