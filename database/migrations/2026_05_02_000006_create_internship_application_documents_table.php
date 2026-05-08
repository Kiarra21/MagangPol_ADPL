<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internship_application_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('internship_applications')->cascadeOnDelete();
            $table->enum('document_type', ['submission_letter', 'proposal', 'other']);
            $table->string('file_path');
            $table->string('original_name');
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->timestamps();

            $table->unique(['application_id', 'document_type'], 'int_app_docs_appid_doc_type_uq');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internship_application_documents');
    }
};
