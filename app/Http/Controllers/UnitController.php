<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitOfficerRequest;
use App\Http\Requests\UnitRequest;
use App\Http\Resources\UnitResource;
use App\Http\Resources\UnitViolationResource;
use App\Models\Unit;
use App\Models\UnitOfficer;
use App\Models\UnitViolation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UnitController extends MasterController
{
    public function index()
    {
        return response()->json([
            'status' => 200,
            'data'   => UnitResource::collection(Unit::all())
        ]);
    }

    public function store(UnitRequest $request)
    {
        Unit::create($request->all());
        return response()->json(['status' => 200, 'msg' => 'تم اضافة الوحدة']);
    }

    public function show(Unit $unit)
    {
        $unitViolation = UnitViolation::whereUnitId($unit->id);
        if (!$this->isAdmin())
            $unitViolation = $unitViolation->whereUserId($this->user()->id);
        return response()->json([
            'status' => 200,
            'data' => UnitViolationResource::collection($unitViolation->get())
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $unit->update($request->all());
        return response()->json(['status' => 200, 'msg' => 'تم تحديث الوحدة']);
    }

    public function setUnitOfficer(UnitOfficerRequest $request)
    {
        $unitOfficer = UnitOfficer::whereUnitId($request->unit_id)->orderByDesc('id')->first();
        if ($unitOfficer)
            $unitOfficer->update(['expires_at' => Carbon::now()]);
        UnitOfficer::create($request->all());
        return response()->json(['status' => 200, 'msg' => 'تمت العملية بنجاح']);
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return response()->json(['status' => 200, 'msg' => 'تم حذف الوحدة']);
    }
}
