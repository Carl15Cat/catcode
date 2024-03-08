<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Task;
use App\Models\Group;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group_task', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Task::class)->constrained()->onDelete('cascade');;
            $table->foreignIdFor(Group::class)->constrained()->onDelete('cascade');;
            $table->datetime('deadline');
            $table->timestamps();

            $table->unique(['task_id', 'group_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_task');
    }
};
