<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\SchoolResource;
use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\SchoolIndexRequest;
use App\Http\Requests\Api\SchoolStoreRequest;
use App\Http\Requests\Api\SchoolUpdateRequest;

class SchoolController extends Controller
{

     public function index(SchoolIndexRequest $request)
    {
        $this->authorize('viewAny', School::class);

        $query = School::with(['district', 'schoolType'])
            ->visibleTo($request->user());

        if ($request->filled('district_id')) {
            $query->where('district_id', $request->integer('district_id'));
        }

        if ($request->filled('school_type_id')) {
            $query->where('school_type_id', $request->integer('school_type_id'));
        }

        if ($request->filled('ownership_type')) {
            $query->where('ownership_type', $request->input('ownership_type'));
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $perPage = $request->integer('per_page', 15);

        return SchoolResource::collection(
            $query->paginate($perPage)
    );
    }

    public function show(School $school)
    {
        $this->authorize('view', $school);

        $school->load(['district', 'schoolType']);
        return new SchoolResource($school);

    }

    public function store(SchoolStoreRequest $request)
    {
        $this->authorize('create', [School::class, $request->validated()]);

        $school = School::create($request->validated());

        $school->load(['district', 'schoolType']);

        return new SchoolResource($school);
    }

    public function update(SchoolUpdateRequest $request, School $school)
    {
        $this->authorize('update', $school);

        $school->update($request->validated());

        $school->load(['district', 'schoolType']);

        return new SchoolResource($school);
    }

    public function destroy(School $school)
    {
        $this->authorize('delete', $school);

        $school->delete();

        return response()->json([
            'message' => 'School deleted successfully.',
        ]);
    }

    public function restore(int $id)
    {
        $school = School::withTrashed()->findOrFail($id);

        $this->authorize('restore', $school);

        $school->restore();

        $school->load(['district', 'schoolType']);

        return new SchoolResource($school);
    }
}
