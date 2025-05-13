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
    Schema::create('paiements', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('inscription_id');
        $table->decimal('montant', 8, 2);
        $table->string('mode'); // 'carte' ou 'espece'
        $table->date('date');
        $table->timestamps();

        $table->foreign('inscription_id')->references('id')->on('inscriptions')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paiements');
    }
};
