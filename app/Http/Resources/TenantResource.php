<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'project_name' => $this->username,
            'domain' => $this->domain,
            'subdomain' => $this->aliases,
            'cloudflare' => CloudFlareResource::make($this->whenLoaded('cloudflare')),
        ];
    }
}
