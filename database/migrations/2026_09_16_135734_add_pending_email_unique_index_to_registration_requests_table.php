<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE registration_requests
            ADD COLUMN pending_email VARCHAR(255)
            GENERATED ALWAYS AS (
                CASE
                    WHEN status = 'pending' THEN email
                    ELSE NULL
                END
            ) STORED
        ");

        Schema::table('registration_requests', function (Blueprint $table) {
            $table->unique('pending_email');
        });
    }

    public function down(): void
    {
        Schema::table('registration_requests', function (Blueprint $table) {
            $table->dropUnique(['pending_email']);
        });

        DB::statement("
            ALTER TABLE registration_requests
            DROP COLUMN pending_email
        ");
    }
};
