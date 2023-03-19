<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cloudflare_id')->nullable()->constrained('cloud_flares');

            $table->string('site_id')->nullable();
            $table->string('project_name');
            $table->string('domain');
            $table->string('subdomain')->nullable();
            $table->string('forge_status')->nullable();
            $table->string('cloudflare_status')->nullable();
            $table->string('cloudflare_zone_id')->nullable();
            $table->string('ssl_status')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
