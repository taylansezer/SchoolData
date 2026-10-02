<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DistrictStoreRequest;
use App\Http\Requests\Api\DistrictUpdateRequest;
use App\Models\District;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', District::class);
        $districts = District::with('province')
            ->visibleTo($request->user())
            ->orderBy('name')
            ->get();

        return response()->json([
            'data' => $districts,
        ]);
    }

    public function show(District $district): JsonResponse
    {
        $this->authorize('view', $district);

        return response()->json([
            'data' => $district->load('province'),
        ]);
    }

    public function store(DistrictStoreRequest $request): JsonResponse
    {
        $this->authorize('create', District::class);

        $district = District::create($request->validated());

        return response()->json([
            'data' => $district->load('province'),
        ], 201);
    }

    public function update(DistrictUpdateRequest $request, District $district): JsonResponse
    {
        $this->authorize('update', $district);

        $district->update($request->validated());

        return response()->json([
            'data' => $district->load('province'),
        ]);
    }

    public function destroy(District $district): JsonResponse
    {
        $this->authorize('delete', $district);

        $district->delete();

        return response()->json([
            'message' => 'District deleted successfully.',
        ]);
    }

    public function restore(int $id): JsonResponse
    {
        $district = District::withTrashed()->findOrFail($id);

        $this->authorize('restore', $district);

        $district->restore();

        return response()->json([
            'data' => $district->load('province'),
        ]);
    }
}
