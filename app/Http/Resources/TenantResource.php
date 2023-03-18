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
            'username' => $this->username,
            'site_id' => $this->site_id,
            'domain' => $this->domain,
            'aliases' => $this->aliases,
            'directory' => $this->directory,
            'status' => $this->status,
            'deployment_url' => $this->deployment_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'cloudflare' => CloudFlareResource::make($this->whenLoaded('cloudflare')),

        ];
    }
}
