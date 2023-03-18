<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['cloudflare_id', 'username', 'site_id', 'domain', 'aliases', 'directory', 'status', 'deployment_url'];
    protected $casts = [
        'aliases' => 'array',
    ];

    public function cloudflare(): BelongsTo
    {
        return $this->belongsTo(CloudFlare::class);
    }
}
