<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relation avec la table users
            $table->string('destination');
            $table->date('date_depart');
            $table->date('date_retour');
            $table->float('budget');
            $table->json('preferences')->nullable(); // Stockage des préférences en JSON
            $table->string('type_voyage')->nullable(); // Type de voyage (ex: aventure, détente, culturel)
            $table->string('style_hebergement')->nullable(); // Style d'hébergement (ex: hôtel, auberge, camping)
            $table->string('transport_prefere')->nullable(); // Transport préféré (ex: avion, train, voiture)
            $table->string('climat_souhaite')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trips');
    }
};
