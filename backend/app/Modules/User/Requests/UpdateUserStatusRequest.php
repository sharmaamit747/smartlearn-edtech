<?php

namespace App\Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Modules\User\Models\User;

class UpdateUserStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                'string',
                'in:' . implode(',', [
                    User::STATUS_ACTIVE,
                    User::STATUS_INACTIVE,
                    User::STATUS_BLOCKED,
                ]),
            ],
        ];
    }
}
