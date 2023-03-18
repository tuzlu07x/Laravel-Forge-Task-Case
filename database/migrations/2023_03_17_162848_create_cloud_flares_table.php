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
        Schema::create('cloud_flares', function (Blueprint $table) {
            $table->id();

            $table->string('domain');
            $table->string('status');

            $table->json('name_servers');

            $table->boolean('success');

            $table->timestamp('created_on');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forge_sites');
    }
};
