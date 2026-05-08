<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internship_application_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('internship_applications')->cascadeOnDelete();
            $table->enum('stage', ['submission', 'admin', 'final']);
            $table->enum('status', ['draft', 'submitted', 'approved', 'rejected']);
            $table->foreignId('acted_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['application_id', 'stage', 'status'], 'iasl_app_stage_status_idx');
            $table->index(['acted_by_user_id', 'created_at'], 'iasl_actor_created_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internship_application_status_logs');
    }
};
