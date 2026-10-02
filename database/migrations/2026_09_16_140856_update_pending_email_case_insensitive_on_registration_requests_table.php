<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE registration_requests
            MODIFY COLUMN pending_email VARCHAR(255)
            GENERATED ALWAYS AS (
                CASE
                    WHEN status = 'pending' THEN LOWER(email)
                    ELSE NULL
                END
            ) STORED
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE registration_requests
            MODIFY COLUMN pending_email VARCHAR(255)
            GENERATED ALWAYS AS (
                CASE
                    WHEN status = 'pending' THEN email
                    ELSE NULL
                END
            ) STORED
        ");
    }
};
