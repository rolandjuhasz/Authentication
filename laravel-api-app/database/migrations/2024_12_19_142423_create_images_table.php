<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_create_images_table.php
public function up()
{
    Schema::create('images', function (Blueprint $table) {
        $table->id();
        $table->string('image_name');
        $table->string('category')->after('image_name');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('category'); 
        });
    }
};
