<?php

namespace App\Modules\Enrollment\Events;

use App\Modules\Enrollment\Models\Enrollment;

class EnrollmentCancelled
{
    public function __construct(
        public readonly Enrollment $enrollment
    ) {}
}
