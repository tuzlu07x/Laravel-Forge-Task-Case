<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TenantRequest;
use App\Http\Resources\TenantResource;
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
