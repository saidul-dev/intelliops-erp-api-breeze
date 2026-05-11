<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('site_settings')->insert([
            ['key' => 'site_name', 'value' => 'IntelliOps ERP', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_logo', 'value' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_favicon', 'value' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_description', 'value' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_keywords', 'value' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_author', 'value' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_email', 'value' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_phone', 'value' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_address', 'value' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
