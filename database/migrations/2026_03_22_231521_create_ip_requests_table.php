<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ip_requests', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 45); // soporta IPv6
            $table->string('rir', 50)->nullable();
            $table->string('company_name', 150)->nullable();
            $table->string('company_domain', 150)->nullable();
            $table->string('abuse_score', 50)->nullable();
            $table->decimal('lat', 10, 6)->nullable();
            $table->decimal('lon', 10, 6)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('zipcode', 20)->nullable();
            $table->timestamps(); // crea created_at y updated_at
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ip_requests');
    }
};
