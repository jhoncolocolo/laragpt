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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title',255)->comment("Program's Table title");
            $table->text('description')->nullable()->comment("Program's Table description");
            $table->date('start_date')->comment("Program's Table start_date");
            $table->date('end_date')->comment("Program's Table end_date");
            $table->unsignedBigInteger('user_id')->comment("Users Table Id ");
            $table->timestamps();
    
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        
        });
         DB::statement("ALTER TABLE `programs` comment 'Programs Table'");
    }

    /**
     * Reverse the migrations.
     *
     * @return    void
     */
    public function down()
    {
        Schema::dropIfExists('programs');
    }
};