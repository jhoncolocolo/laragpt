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
        Schema::create('program_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id')->comment("Programs Table Id ");
            $table->morphs('entitiable');
            $table->timestamps();
            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->onUpdate('cascade')
                ->onDelete('cascade');

        });
         DB::statement("ALTER TABLE `program_participants` comment 'Program Participants Table'");
    }

    /**
     * Reverse the migrations.
     *
     * @return    void
     */
    public function down()
    {
        Schema::dropIfExists('program_participants');
    }
};
