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
        Schema::create('programming_languages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('version');
            $table->text('default_code');
            $table->string('highlight_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programming_languages');
    }
};
