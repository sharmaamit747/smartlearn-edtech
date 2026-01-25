<?php

namespace App\Modules\Course\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Course\Models\Course;
use App\Modules\Course\Services\CourseService;
use App\Modules\Course\Resources\CourseResource;

class CourseController extends Controller
{
    public function __construct(
        protected CourseService $courseService
    ) {}

    public function index(Request $request)
    {
        $courses = $this->courseService->list($request);

        return response()->json([
            'data' => CourseResource::collection($courses),
            'meta' => [
                'per_page' => $courses->perPage(),
                'total' => $courses->total(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Course::class);

        $course = $this->courseService->create(
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ])
        );

        return new CourseResource($course);
    }

    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $updated = $this->courseService->update(
            $course,
            $request->validate([
                'title' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'status' => 'sometimes|in:DRAFT,PUBLISHED,ARCHIVED',
            ])
        );

        return new CourseResource($updated);
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $this->courseService->delete($course);

        return response()->json([
            'message' => 'Course deleted successfully',
        ]);
    }
}
