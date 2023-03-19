<?php

namespace App\Jobs;

use App\Models\Tenant;
use App\Models\CloudFlare;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CloudFlareNotification;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Integration\CloudFlare as CloudFlareClass;

class CloudFlareJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected Tenant $tenant;
    protected $counter;

    /**
     * Create a new job instance.
     */
    public function __construct(Tenant $tenant, int $counter)
    {
        $this->tenant = $tenant;
        $this->counter = $counter;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $classCloudFlare = new CloudFlareClass(config('cloudflare.url'), config('cloudflare.email'), config('cloudflare.apiKey'), config('cloudflare.accountId'));
        $data = $classCloudFlare->createSite($this->tenant->domain);
        $this->isSuccess($data);
        $this->createCloudflareData($data);
        if ($this->counter === 3)
            $this->sendMail();

        LaravelForgeJob::dispatch($this->tenant, $this->counter);
    }

    public function isSuccess(array $data): void
    {
        if ($data['success'] == false) {
            $this->tenant->update(['cloudflare_status' => 'error']);
            while ($this->counter < 3 && $data['success'] == false) {
                $this->counter++;
                self::dispatch($this->tenant, $this->counter)->delay(now()->addSeconds());
            }
        } else {
            $this->tenant->update(['cloudflare_status' => 'success', 'cloudflare_zone_id' => $data['result']['id']]);
        }
    }

    public function sendMail(): void
    {
        Notification::route('mail', 'fatihtuzlu07@gmail.com')->notify(new CloudFlareNotification($this->tenant));
    }

    public function createCloudflareData(array $data): void
    {
        if (!empty($data['result'])) {
            $model = CloudFlare::create([
                'domain' => $data['result']['name'],
                'status' => $data['result']['status'],
                'name_servers' => $data['result']['name_servers'],
                'success' => $data['success'],
            ]);
            $this->tenant->update(['cloudflare_id' => $model->id]);
            $this->sendMail();
        }
    }
}
