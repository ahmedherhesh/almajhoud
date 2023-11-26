<?php

namespace App\Http\Requests;


class UnitOfficerRequest extends MasterRequest
{

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'unit_id' => 'required|exists:units,id',
            'expires_at' => 'nullable|date_format:Y-m-d H:i:s',
        ];
    }
}
