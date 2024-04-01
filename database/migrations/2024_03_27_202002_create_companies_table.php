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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->comment("Company's Table name");
            $table->string('image_path',255)->nullable()->comment("Company's Table image_path");
            $table->string('location',255)->comment("Company's Table location");
            $table->string('industry',255)->comment("Company's Table industry");
            $table->unsignedBigInteger('user_id')->comment("Users Table Id ");
            $table->timestamps();
    
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        
        });
         DB::statement("ALTER TABLE `companies` comment 'Companies Table'");
    }

    /**
     * Reverse the migrations.
     *
     * @return    void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};