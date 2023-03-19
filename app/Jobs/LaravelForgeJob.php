<?php

namespace App\Jobs;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use App\Integration\Forge\Site;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Notifications\LaravelForgeNotification;

class LaravelForgeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected Tenant $tenant;
    protected $counter = 0;
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
        $this->createForgeSite();
        if ($this->counter == 3) {
            $this->sendMail();
            return;
        }
    }

    public function createForgeSite()
    {
        $site = new Site(config('forge.serverId'), $this->tenant->domain, 'php', '/home/forge/fatihtuzlu.org', $this->tenant->project_name, ['tuzlu.org'], true);
        $forge = $this->laravelForgeSite($site);
        $response = $forge->createSite();
        $this->updateForgeStatus($response);
    }

    public function laravelForgeSite(Site $site)
    {
        return $this->tenant->laravelForge($site);
    }

    public function sendMail(): void
    {
        Notification::route('mail', 'fatihtuzlu07@gmail.com')->notify(new LaravelForgeNotification($this->tenant));
    }

    public function delayWithCounter(): void
    {
        while ($this->counter < 3) {
            self::dispatch($this->tenant, $this->counter)->delay(now()->addSeconds());
            $this->counter++;
        }
    }

    public function updateForgeStatus(array $response): void
    {
        if (!isset($response['domain'])) {
            $this->tenant->update(['site_id' => $response['site']['id'], 'forge_status' => 'success']);
            return;
        } else {
            $this->delayWithCounter();
            $this->tenant->update(['forge_status' => 'error']);
        }
    }
}
