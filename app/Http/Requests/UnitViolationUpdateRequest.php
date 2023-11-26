<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitViolationUpdateRequest extends MasterRequest
{

    public function rules(): array
    {
        return [
            'unit_id' => 'required|exists:units,id',
            'count'   => 'required|integer'
        ];
    }
}
