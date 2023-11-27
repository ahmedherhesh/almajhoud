<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ViolationRequest extends MasterRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|min:3|max:255'
        ];
    }
}
