<?php

namespace App\Modules\Course\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\User\Models\User;
use Database\Factories\CourseFactory;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected static function newFactory()
    {
        return CourseFactory::new();
    }

    protected $fillable = [
        'title',
        'description',
        'status',
        'created_by',
    ];

    public const STATUS_DRAFT = 'DRAFT';
    public const STATUS_PUBLISHED = 'PUBLISHED';
    public const STATUS_ARCHIVED = 'ARCHIVED';

    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
