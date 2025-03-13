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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itineraire_id')->constrained('itineraires')->onDelete('cascade');
            $table->string('nom');
            $table->string('lieu_logement'); // Lieu de logement
            $table->jsonb('endroits_visite'); // Liste des endroits à visiter (JSONB pour PostgreSQL)
            $table->jsonb('activites'); // Liste des activités (JSONB)
            $table->jsonb('plats'); // Liste des plats à essayer (JSONB)
            $table->timestamps(); // Colonnes created_at et updated_at
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
