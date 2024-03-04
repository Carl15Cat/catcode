<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Task;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('autotests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Task::class);
            $table->string('name')->default('Без названия');
            $table->json('variables');
            $table->string('expected_output');
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autotests');
    }
};
