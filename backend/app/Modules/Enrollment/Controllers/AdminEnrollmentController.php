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


        $version = Cache::get('admin_enrollments_version', 1);

        $cacheKey = "admin_enrollments:v{$version}:" .
            md5(json_encode($request->query()));

        $data = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($request) {

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
                    $request->search,
                    fn($q) =>
                    $q->where(function ($qq) use ($request) {
                        $qq->where('users.name', 'like', "%{$request->search}%")
                            ->orWhere('users.email', 'like', "%{$request->search}%");
                    })
                )
                ->latest('enrollments.created_at')
                ->paginate(20);
        });

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
