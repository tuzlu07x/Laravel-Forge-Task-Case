<?php

namespace App\Observers;

use App\Models\Tenant;
use App\Jobs\CloudFlareJob;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CloudFlareNotification;

class LaravelForgeObserver
{
    public function created(Tenant $tenant): void
    {
        $counter = 0;
        CloudFlareJob::dispatchSync($tenant, $counter);
    }
}
