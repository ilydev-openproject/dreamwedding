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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('slug')->unique(); // For public view (/invite/rendy-arumi)
            $table->string('template_id')->default('ar019');
            $table->string('access_token')->unique(); // For the secret dashboard link
            $table->json('content')->nullable(); // The specific data for the invitation
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
