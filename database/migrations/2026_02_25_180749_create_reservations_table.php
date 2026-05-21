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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('id_reservation');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('etat')->default('Nouvelle');

            $table->foreignId('id_client')
              ->constrained('clients', 'id_client')
              ->onDelete('cascade');

            $table->foreignId('id_chambre')
              ->constrained('chambres', 'id_chambre')
              ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
