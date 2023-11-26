<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitViolationRequest;
use App\Models\UnitViolation;
use Illuminate\Http\Request;

class UnitViolationController extends MasterController
{

    public function store(UnitViolationRequest $request)
    {
        $userUnit = $this->user()->unit;
        if ($userUnit->unit_id == $request->unit_id)
            UnitViolation::create($request->all());
    }

    public function update(Request $request, UnitViolation $unitViolation)
    {
        //
    }

    public function destroy(UnitViolation $unitViolation)
    {
        //
    }
}
