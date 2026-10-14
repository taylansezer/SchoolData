<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Directorate;
use App\Models\District;
use App\Models\School;
use App\Models\SchoolType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class SchoolController extends Controller
{
    public function index(Request $request): Response
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'school_type_id' => ['nullable', 'integer', 'exists:school_types,id'],
            'district_id' => ['nullable', 'integer', 'exists:districts,id'],
        ]);

        $schools = School::with(['district', 'schoolType'])
            ->visibleTo($request->user())
            ->when(
                $validated['search'] ?? null,
                function ($query, $search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere(
                                'institution_code',
                                'like',
                                "%{$search}%"
                            );
                    });
                }
            )
            ->when(
                $validated['school_type_id'] ?? null,
                fn ($query, $schoolTypeId) => $query->where(
                    'school_type_id',
                    $schoolTypeId
                )
            )
            ->when(
                $validated['district_id'] ?? null,
                fn ($query, $districtId) => $query->where(
                    'district_id',
                    $districtId
                )
            )
            ->paginate(15);

        $districts = District::visibleTo($request->user())
            ->orderBy('name')
            ->get(['id', 'name']);

        $schoolTypes = SchoolType::orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('schools/index', [
            'schools' => $schools,
            'districts' => $districts,
            'schoolTypes' => $schoolTypes,
            'filters' => [
                'search' => $validated['search'] ?? '',
                'school_type_id' => $validated['school_type_id'] ?? '',
                'district_id' => $validated['district_id'] ?? '',
            ],
        ]);
    }

    public function create(Request $request): Response
    {
        abort_unless(
            $request->user()->hasPermission('school.create'),
            403
        );

        $districts = District::visibleTo($request->user())
            ->orderBy('name')
            ->get(['id', 'name']);

        $schoolTypes = SchoolType::orderBy('name')
            ->get(['id', 'name']);

        $directorates = Directorate::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('schools/create', [
            'districts' => $districts,
            'schoolTypes' => $schoolTypes,
            'directorates' => $directorates,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'district_id' => ['required', 'integer', 'exists:districts,id'],
            'directorate_id' => ['nullable', 'integer', 'exists:directorates,id'],
            'institution_code' => [
                'required',
                'integer',
                'min:1',
                'unique:schools,institution_code',
            ],
            'school_type_id' => [
                'required',
                'integer',
                'exists:school_types,id',
            ],
            'name' => ['required', 'string', 'max:255'],
            'ownership_type' => [
                'required',
                Rule::in(['resmi', 'özel']),
            ],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'student_count' => ['required', 'integer', 'min:0'],
            'teacher_count' => ['required', 'integer', 'min:0'],
            'classroom_count' => ['required', 'integer', 'min:0'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $this->authorize('create', [School::class, $validated]);

        School::create($validated);

        return to_route('schools.index')
            ->with('success', 'Okul başarıyla oluşturuldu.');
    }
}
