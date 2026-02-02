<?php

namespace App\Modules\Enrollment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Course\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InstructorEnrollmentController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request, Course $course)
    {
        $this->authorize('viewEnrollments', $course);

        $enrollments = $course->enrollments()
            ->with([
                'student:id,name,email',
                'course:id,title'
            ])
            ->latest()
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'message' => 'Course enrollments fetched successfully',
            'data' => $enrollments
        ]);
    }
}
