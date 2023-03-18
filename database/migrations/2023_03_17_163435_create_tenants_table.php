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
            $table->string('username');
            $table->string('site_id')->nullable();
            $table->string('domain');
            $table->json('aliases');
            $table->string('directory');
            $table->string('status')->default('pending');
            $table->string('deployment_url')->nullable();

            $table->enum('type', ['sub_domain', 'domain'])->default('domain');
            $table->timestamps();
            $table->softDeletes();
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
