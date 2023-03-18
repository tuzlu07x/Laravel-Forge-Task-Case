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

            $table->string('username');
            $table->string('site_id');
            $table->string('domain');
            $table->json('aliases');
            $table->string('directory');
            $table->string('status');
            $table->string('deployment_url');

            $table->enum('type', ['sub_domain', 'domain'])->default('domain');
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
