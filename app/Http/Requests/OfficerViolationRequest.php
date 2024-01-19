<?php

namespace App\Http\Requests;


class OfficerViolationRequest extends MasterRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'violation_id' => 'required|exists:violations,id',
            'count' => 'required|integer',
        ];
    }
}
