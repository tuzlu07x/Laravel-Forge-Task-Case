<?php

namespace App\Http\Requests;

class TenantRequest extends ApiRequest
{
    public function commonRules()
    {
        return [
            'project_name' => 'required|string',
            'domain' => 'required|string|unique:tenants,domain',
            'subdomain' => 'nullable|string',
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
