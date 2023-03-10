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
        Schema::create('chambre', function (Blueprint $table) {
            $table->id();
            $table->string('type_de_chambre');
            $table->string('etage');
            $table->float('prix_par_nuit');
            $table->string('disponibilite');
            $table->string('image')->default('images');
            $table->string('image2')->default('images');
            $table->string('image3')->default('images');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chambre');
    }
};
