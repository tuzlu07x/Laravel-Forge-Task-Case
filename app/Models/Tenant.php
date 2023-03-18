<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;
    protected $fillable = ['username', 'site_id', 'domain', 'aliases', 'directory', 'status', 'deployment_url'];
    protected $casts = [
        'aliases' => 'array',
    ];
}
