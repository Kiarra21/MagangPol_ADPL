<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran_magang', function (Blueprint $table) {
            $table->id();
            $table->string('application_number', 50)->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('period_id')->constrained('periode_magang')->cascadeOnDelete();
            $table->foreignId('assigned_division_id')->nullable()->constrained('divisi_magang')->nullOnDelete();
            $table->string('institution_name');
            $table->string('study_program')->nullable();
            $table->enum('submission_status', ['draft', 'submitted', 'admin_review', 'final_review', 'approved', 'rejected'])->default('draft')->index();
            $table->enum('status_admin', ['pending', 'approved', 'rejected'])->default('pending')->index();
            $table->enum('status_final', ['pending', 'approved', 'rejected'])->default('pending')->index();
            // admin_notes and final_notes removed; use status logs for audit/note history
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
        Schema::dropIfExists('pendaftaran_magang');
    }
};