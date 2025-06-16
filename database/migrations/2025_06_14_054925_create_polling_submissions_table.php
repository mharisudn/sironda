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
        Schema::disableForeignKeyConstraints();

        Schema::create('polling_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('polling_code_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ronda_termin_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('sort')->default(1);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polling_submissions');
    }
};
