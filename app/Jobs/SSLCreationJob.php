<?php

namespace App\Jobs;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use App\Integration\Forge\SSL;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Notifications\LaravelForgeSSLNotification;

class SSLCreationJob implements ShouldQueue
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

    public function laravelForgeSSL(SSL $ssl): \App\Integration\Forge\Forge
    {
        return $this->tenant->laravelForge(null, $ssl);
    }

    public function ssl(): SSL
    {
        return new SSL('new', 'USA', 'NY', 'New York', 'Company sdd', 'IT', $this->tenant->site_id, config('forge.serverId'));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->counter === 3 || $this->tenant->site_id === null) {
            $this->sendMail();
            return;
        }
        $this->hasSSL();
        if ($this->tenant->ssl_status === 'success') {
            $this->sendMail();
        }
        return;
    }

    public function createSll()
    {
        $ssl = $this->ssl();
        $forge = $this->laravelForgeSSL($ssl);

        $this->tenant->update(['ssl_status' => 'success']);
        return $forge->createSSL($this->tenant->domain);
    }

    public function listSSL()
    {
        $ssl = $this->ssl();
        $forge = $this->laravelForgeSSL($ssl);

        return $forge->listSSL();
    }

    public function hasSSL(): void
    {
        $ssl = $this->listSSL();
        if (count($ssl['certificates']) != 0) {
            collect($ssl['certificates'])->each(function ($item) {
                if ($item['domain'] == $this->tenant->domain) {
                    $this->tenant->update(['ssl_status' => 'error']);
                    while ($this->counter < 3) {
                        $this->counter++;
                        self::dispatch($this->tenant, $this->counter)->delay(now()->addSeconds(60));
                        return;
                    }
                }
            });
        } else {
            $this->createSll();
        }
    }

    public function sendMail()
    {
        Notification::route('mail', 'fatihtuzlu07@gmail.com')->notify(new LaravelForgeSSLNotification($this->tenant));
    }
}
