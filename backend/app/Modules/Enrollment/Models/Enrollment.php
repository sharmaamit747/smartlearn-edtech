<?php

namespace App\Modules\Enrollment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\User\Models\User;
use App\Modules\Course\Models\Course;
use Database\Factories\EnrollmentFactory;

class Enrollment extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return EnrollmentFactory::new();
    }

    protected $fillable = [
        'user_id',
        'course_id',
        'status',
        'enrolled_at',
        'cancelled_at',
        'completed_at',
    ];

    /* =====================
     |  STATUS CONSTANTS
     ===================== */

    public const STATUS_PENDING   = 'PENDING';
    public const STATUS_ACTIVE    = 'ACTIVE';
    public const STATUS_CANCELLED = 'CANCELLED';
    public const STATUS_COMPLETED = 'COMPLETED';
    public const STATUS_ENROLLED  = 'ENROLLED';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_ACTIVE,
        self::STATUS_CANCELLED,
        self::STATUS_COMPLETED,
        self::STATUS_ENROLLED,
    ];

    /* =====================
     |  RELATIONSHIPS
     ===================== */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
