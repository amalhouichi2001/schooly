<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('eleve_parent', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('eleve_id');
        $table->unsignedBigInteger('parent_id');
        $table->timestamps();

        $table->foreign('eleve_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eleve_parent');
    }
};
