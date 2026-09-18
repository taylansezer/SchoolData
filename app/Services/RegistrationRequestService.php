<?php

namespace App\Services;

use App\Exceptions\RegistrationRequestConflictException;
use App\Models\RegistrationRequest;
use Illuminate\Database\UniqueConstraintViolationException;
use App\Enums\RegistrationRequestStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegistrationRequestService
{
    public function create(array $data): RegistrationRequest
    {
       try {
            return RegistrationRequest::create($data);
        } catch (UniqueConstraintViolationException $exception) {
            throw new RegistrationRequestConflictException(
                'There is already an active registration for this email address.',
                previous: $exception
            );
        }
    }

    public function approve(RegistrationRequest $registrationRequest,User $reviewer): User {
        return DB::transaction(function () use ($registrationRequest, $reviewer) {

            $user = User::create([
                'first_name' => $registrationRequest->first_name,
                'last_name' => $registrationRequest->last_name,
                'email' => $registrationRequest->email,
                'password' => str()->random(32),
            ]);

            $user->roles()->attach(
                $registrationRequest->requested_role_id,
                [
                    'scope_type' => $registrationRequest->scope_type->value,
                    'scope_id' => $registrationRequest->scope_id,
                ]
            );

            $registrationRequest->update([
                'status' => RegistrationRequestStatus::APPROVED,
                'reviewed_by' => $reviewer->id,
                'reviewed_at' => now(),
            ]);

            return $user;
        });
    }

    public function reject(RegistrationRequest $registrationRequest,User $reviewer): RegistrationRequest {
        return DB::transaction(function () use ($registrationRequest, $reviewer) {

            $registrationRequest->status = RegistrationRequestStatus::REJECTED;
            $registrationRequest->reviewed_by = $reviewer->id;
            $registrationRequest->reviewed_at = now();
            $registrationRequest->save();

            return $registrationRequest;
        });
    }
}
