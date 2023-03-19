<?php

namespace App\Models;

use App\Integration\Forge\Forge;
use App\Observers\LaravelForgeObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Tenant extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['cloudflare_id', 'site_id', 'project_name', 'domain', 'subdomain', 'forge_status', 'cloudflare_status', 'ssl_status', 'cloudflare_zone_id'];

    public static function boot()
    {
        parent::boot();

        Tenant::observe(LaravelForgeObserver::class);
    }

    public function cloudflare(): BelongsTo
    {
        return $this->belongsTo(CloudFlare::class);
    }

    public function laravelForge($site = null, $ssl = null)
    {
        $forge = new Forge($site, $ssl, config('forge.clientId'), config('forge.serverId'), config('forge.apiKey'));

        return $forge;
    }
}
