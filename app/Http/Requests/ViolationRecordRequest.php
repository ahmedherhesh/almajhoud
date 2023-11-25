<?php

namespace App\Http\Requests;


class ViolationRecordRequest extends MasterRequest
{
    public function rules(): array
    {
        return [
            'unit_id' => 'required|exists:units,id',
            'violation_id' => 'required|exists:violations,id',
            'count' => 'required|integer'
        ];
    }
}
