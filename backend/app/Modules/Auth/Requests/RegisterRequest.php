<?php

namespace App\Modules\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest as HttpFormRequest;
use Illuminate\Support\Http\FormRequest;

class RegisterRequest extends HttpFormRequest
{

    public function authoriza(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required | string | max:255',
            'email' => 'required | email',
            'password' => 'required | min:6',
        ];
    }
}
