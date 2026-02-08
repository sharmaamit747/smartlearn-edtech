<?php

namespace App\Modules\Enrollment\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Enrollment\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;

class AdminEnrollmentController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {


        $cacheKey = 'admin_enrollments:' . md5(json_encode($request->query()));

        $data = Cache::tags(['admin_enrollments'])
            ->remember($cacheKey, 300, function () use ($request) {

                return Enrollment::query()
                    ->join('users', 'users.id', '=', 'enrollments.user_id')
                    ->join('courses', 'courses.id', '=', 'enrollments.course_id')
                    ->select(
                        'enrollments.*',
                        'users.name as student_name',
                        'users.email',
                        'courses.title as course_title'
                    )
                    ->when(
                        $request->course_id,
                        fn($q) =>
                        $q->where('enrollments.course_id', $request->course_id)
                    )
                    ->when(
                        $request->user_id,
                        fn($q) =>
                        $q->where('enrollments.user_id', $request->user_id)
                    )
                    ->when(
                        $request->status,
                        fn($q) =>
                        $q->where('enrollments.status', $request->status)
                    )
                    ->when(
                        $request->search,
                        fn($q) =>
                        $q->where(function ($qq) use ($request) {
                            $qq->where('users.name', 'like', "%{$request->search}%")
                                ->orWhere('users.email', 'like', "%{$request->search}%");
                        })
                    )
                    ->orderByDesc('enrollments.created_at')
                    ->paginate(20);
            });

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
