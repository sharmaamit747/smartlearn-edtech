<?php

namespace App\Modules\Course\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Modules\Course\Models\Course;
use App\Modules\Course\Services\CourseService;
use App\Modules\Course\Resources\CourseResource;

class CourseController extends Controller
{
    use AuthorizesRequests;
    public function __construct(
        protected CourseService $courseService
    ) {}

    public function index(Request $request)
    {
        $perPage = min((int) $request->get('per_page', 10), 100);

        $paginator = $this->courseService
            ->list($request)
            ->paginate($perPage);

        return CourseResource::collection($paginator)
            ->additional([
                'meta' => [
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                ]
            ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Course::class);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course = $this->courseService->create([
            ...$data,
            'created_by' => $request->user()->id,
        ]);


        return (new CourseResource($course))
            ->response()
            ->setStatusCode(201);
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

    public function publish(Course $course)
    {
        $this->authorize('publish', $course);

        $course = $this->courseService->publish($course);

        return response()->json([
            'message' => 'Course published successfully',
        ]);
    }
}
