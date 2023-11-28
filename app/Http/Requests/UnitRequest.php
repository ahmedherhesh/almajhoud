<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends MasterRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|unique:units,title|min:2|max:255'
        ];
    }
}
