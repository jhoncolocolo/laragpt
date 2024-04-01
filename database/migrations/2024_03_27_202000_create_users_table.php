<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB; 
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return    void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->comment("User's Table name");
            $table->string('email',255)->unique()->comment("User's Table email");
            $table->string('image_path',255)->nullable()->comment("User's Table image_path");
            $table->timestamps();
        
        });
         DB::statement("ALTER TABLE `users` comment 'Users Table'");
    }

    /**
     * Reverse the migrations.
     *
     * @return    void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};