<?php

use App\Enums\ShiftType;
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

        Schema::create('ronda_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ronda_termin_id')->constrained()->cascadeOnDelete();
            $table->foreignId('polling_code_id')->constrained()->cascadeOnDelete();
            $table->string('shift_type')->default(ShiftType::Mix->value);
            $table->boolean('is_leader')->default(false);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ronda_schedules');
    }
};
