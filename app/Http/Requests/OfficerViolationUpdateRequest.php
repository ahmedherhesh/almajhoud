<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfficerViolationUpdateRequest extends MasterRequest
{

    public function rules(): array
    {
        return [
            'count'   => 'required|integer'
        ];
    }
}
