<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Jobs\CloudFlareJob;
use App\Jobs\SSLCreationJob;
use App\Jobs\LaravelForgeJob;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cloud:push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $counter = 0;
        $tenant = Tenant::first();
        //CloudFlareJob::dispatchSync($tenant, $counter);
        //LaravelForgeJob::dispatchSync($tenant, $counter);
        SSLCreationJob::dispatchSync($tenant, $counter);
    }
}
