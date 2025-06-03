<?php

use App\TodoTaskStatusEnum;
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
        Schema::create('todo_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 350);
            $table->text('description')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', array_map(fn($case) => $case->label(), TodoTaskStatusEnum::cases()))->default(TodoTaskStatusEnum::PENDING->label());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo_tasks');
    }
};
