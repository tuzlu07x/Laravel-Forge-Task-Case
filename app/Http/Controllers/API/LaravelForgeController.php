<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Integration\CloudFlare as CloudFlareClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\TenantRequest;
use App\Http\Resources\CloudFlareResource;
use App\Http\Resources\TenantResource;
use App\Integration\Forge\Forge;
use App\Integration\Forge\Site;
use App\Integration\Forge\SSL;
use App\Models\CloudFlare;
use App\Models\Tenant;

class LaravelForgeController extends Controller
{
    public function createTenant(TenantRequest $request)
    {
        $data = $request->validated();
        $tenant = new Tenant($data);
        $tenant->save();

        return TenantResource::make($tenant);
    }
}
