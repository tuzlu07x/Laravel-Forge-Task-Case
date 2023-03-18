<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Integration\CloudFlare as CloudFlareClass;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CloudFlare extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['domain', 'status', 'name_servers', 'success'];
    protected $casts = ['name_servers' => 'array'];

    public function tenant(): HasOne
    {
        return $this->hasOne(Tenant::class);
    }

    public function createCloudFlare(): CloudFlareClass
    {
        $classCloudFlare = new CloudFlareClass(config('cloudflare.url'), config('cloudflare.email'), config('cloudflare.apiKey'), $this->domain, config('cloudflare.accountId'));

        $data = $classCloudFlare->createSite();
        if (!isset($data->errors)) {
            $cloud = CloudFlare::create([
                'domain' => $data['result']['name'],
                'status' => $data['result']['status'],
                'name_servers' => $data['result']['name_servers'],
                'success' => $data['success'],
            ]);
            return $cloud;
        }

        return response()->json($data->errors, 200);
    }
}
