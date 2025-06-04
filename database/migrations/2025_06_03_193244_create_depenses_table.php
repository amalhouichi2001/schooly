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
    Schema::create('depenses', function (Blueprint $table) {
        $table->id();
        $table->string('description');
        $table->decimal('montant', 10, 2);
        $table->date('date');
        $table->string('categorie')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('depenses');
}

};
