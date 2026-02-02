<?php

namespace App\Modules\Enrollment\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Enrollment\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminEnrollmentController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Enrollment::class);

        $query = Enrollment::query()
            ->with([
                'student:id,name,email',
                'course:id,title,created_by'
            ])
            ->when(
                $request->course_id,
                fn($q) =>
                $q->where('course_id', $request->course_id)
            )
            ->when(
                $request->user_id,
                fn($q) =>
                $q->where('user_id', $request->user_id)
            )
            ->when(
                $request->status,
                fn($q) =>
                $q->where('status', $request->status)
            )
            ->latest();

        return response()->json([
            'success' => true,
            'message' => 'All enrollments fetched successfully',
            'data' => $query->paginate($request->get('per_page', 20)),
        ]);
    }
}
