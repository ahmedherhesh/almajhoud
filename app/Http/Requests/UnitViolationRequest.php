<?php

namespace App\Http\Requests;


class UnitViolationRequest extends MasterRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'unit_id' => 'required|exists:units,id',
            'violation_id' => 'required|exists:violations,id',
            'count' => 'required|integer',
        ];
    }
}
