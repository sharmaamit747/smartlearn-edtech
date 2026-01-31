<?php

namespace App\Modules\Enrollment\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Modules\Enrollment\Services\EnrollmentService;
use App\Modules\Enrollment\Models\Enrollment;
use App\Modules\Course\Models\Course;
use App\Modules\Enrollment\Resources\EnrollmentResource;

class EnrollmentController extends Controller
{
    use AuthorizesRequests;
    public function __construct(
        protected EnrollmentService $enrollmentService
    ) {}

    /**
     * Enroll authenticated user into a course
     */
    public function store(Request $request, Course $course)
    {
        $this->authorize('create', [Enrollment::class, $course]);

        $enrollment = $this->enrollmentService->enroll(
            $request->user(),
            $course
        );

        return (new EnrollmentResource($enrollment))
            ->response()
            ->setStatusCode(201);
    }


    /**
     * Cancel enrollment
     */
    public function cancel(Enrollment $enrollment)
    {
        $this->authorize('cancel', $enrollment);

        $enrollment = $this->enrollmentService->cancel($enrollment);

        return new EnrollmentResource($enrollment);
    }

    public function complete(Enrollment $enrollment)
    {
        $this->authorize('complete', $enrollment);

        $enrollment = $this->enrollmentService->complete($enrollment);

        return new EnrollmentResource($enrollment);
    }
}
