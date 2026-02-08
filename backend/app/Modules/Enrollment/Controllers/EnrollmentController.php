<?php

namespace App\Modules\Enrollment\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Modules\Enrollment\Services\EnrollmentService;
use App\Modules\Enrollment\Models\Enrollment;
use App\Modules\Course\Models\Course;
use App\Modules\Enrollment\Resources\EnrollmentResource;
use App\Modules\Enrollment\Events\{
    EnrollmentCreated,
    EnrollmentCancelled,
    EnrollmentCompleted
};


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

        event(new EnrollmentCreated($enrollment));

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

        event(new EnrollmentCancelled($enrollment));

        return new EnrollmentResource($enrollment);
    }

    public function complete(Enrollment $enrollment)
    {
        $this->authorize('complete', $enrollment);

        $enrollment = $this->enrollmentService->complete($enrollment);

        event(new EnrollmentCompleted($enrollment));

        return new EnrollmentResource($enrollment);
    }

    public function myEnrollments(Request $request)
    {
        // Authorization
        $this->authorize('viewSelf', Enrollment::class);

        $enrollments = Enrollment::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return EnrollmentResource::collection($enrollments);
    }
}
