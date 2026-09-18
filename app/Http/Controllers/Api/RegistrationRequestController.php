<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegistrationRequestStoreRequest;
use App\Models\RegistrationRequest;
use App\Services\RegistrationRequestService;
use Illuminate\Http\Request;

class RegistrationRequestController extends Controller
{
    public function __construct(
        private RegistrationRequestService $registrationRequestService
    ) {
    }

    public function store(RegistrationRequestStoreRequest $request)
    {
        $registrationRequest = $this->registrationRequestService
            ->create($request->validated());

        return response()->json([
            'data' => $registrationRequest->load('requestedRole'),
        ], 201);
    }

    public function approve(Request $request, RegistrationRequest $registrationRequest) {
        $this->authorize('approve', $registrationRequest);

        $user = $this->registrationRequestService->approve(
            $registrationRequest,
            $request->user()
        );

        return response()->json([
            'message' => 'Registration request approved successfully.',
            'data' => $user,
        ]);
    }

    public function reject(Request $request, RegistrationRequest $registrationRequest) {
        $this->authorize('reject', $registrationRequest);

        $registrationRequest = $this->registrationRequestService->reject(
            $registrationRequest,
            $request->user()
        );

        return response()->json([
            'message' => 'Registration request rejected successfully.',
            'data' => $registrationRequest,
        ]);
    }
}


