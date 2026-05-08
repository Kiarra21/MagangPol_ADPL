<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internship_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_number', 50)->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('period_id')->constrained('internship_periods')->cascadeOnDelete();
            $table->foreignId('assigned_division_id')->nullable()->constrained('internship_divisions')->nullOnDelete();
            $table->enum('submission_status', ['draft', 'submitted', 'admin_review', 'final_review', 'approved', 'rejected'])->default('draft')->index();
            $table->enum('status_admin', ['pending', 'approved', 'rejected'])->default('pending')->index();
            $table->enum('status_final', ['pending', 'approved', 'rejected'])->default('pending')->index();
            $table->foreignId('admin_reviewer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('final_reviewer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('submitted_at')->nullable()->index();
            $table->timestamp('admin_reviewed_at')->nullable();
            $table->timestamp('final_reviewed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'period_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internship_applications');
    }
};
