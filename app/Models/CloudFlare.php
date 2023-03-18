<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CloudFlare extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['domain', 'status', 'name_servers', 'success', 'created_on'];
    protected $dates = ['created_on'];
    protected $casts = ['name_servers' => 'array'];
}
