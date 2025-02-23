<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('presencas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained()->onDelete('cascade');
            $table->dateTime('data_hora_presenca')->default(now());
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('presencas');
    }
};
