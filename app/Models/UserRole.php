<?php

namespace App\Models;

use App\Enums\ScopeType;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRole extends Pivot
{
    protected $table = 'user_roles';

    protected function casts(): array
    {
        return [
            'scope_type' => ScopeType::class,
        ];
    }
}
