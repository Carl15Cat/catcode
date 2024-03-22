<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Solution;
use App\Models\Autotest;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('executables', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Solution::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Autotest::class)->constained()->onDelete('cascade');
            $table->string('token')->default("");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('executables');
    }
};
