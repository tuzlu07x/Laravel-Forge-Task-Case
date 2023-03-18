<?php

namespace App\Http\Requests;

class TenantRequest extends ApiRequest
{
    public function commonRules()
    {
        return [
            'cloudflare_id' => 'nullable|exists:cloud_flares,id',
            'username' => 'required|string',
            'site_id' => 'nullable|string',
            'domain' => 'required|string|unique:tenants,domain',
            'aliases' => 'required|array',
            'directory' => 'required|string',
            'status' => 'required|string',
            'project_type' => 'required|string',
            'deployment_url' => 'nullable|string',
            'type' => 'required|in:sub_domain,domain',
        ];
    }

    public function updateRules()
    {
        return [];
    }

    public function storeRules()
    {
        return [];
    }
}
