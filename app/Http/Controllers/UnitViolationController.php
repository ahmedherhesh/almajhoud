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
        return $userUnit;
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
