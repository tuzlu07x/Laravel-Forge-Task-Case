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
}
