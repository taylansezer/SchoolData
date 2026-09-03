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
            Schema::table('schools', function (Blueprint $table) {
            $table->foreignId('school_type_id')
                ->nullable()
                ->after('district_id')
                ->constrained('school_types')
                ->restrictOnDelete();

            $table->string('ownership_type')
                ->default('official')
                ->after('school_type_id');

            $table->dropColumn('school_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropForeign(['school_type_id']);
            $table->dropColumn(['school_type_id', 'ownership_type']);

            $table->string('school_type')
                ->nullable()
                ->after('district_id');
        });
    }
};
