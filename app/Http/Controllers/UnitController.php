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
use Illuminate\Support\Facades\DB;

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

    public function show(Request $request, Unit $unit)
    {
        $unitViolation = UnitViolation::whereUnitId($unit->id);
        if ($request->from)
            $unitViolation->whereDate('created_at', '>=', $request->from);
        if ($request->to)
            $unitViolation->whereDate('created_at', '<=', $request->to);
        if (!$request->from && !$request->to)
            $unitViolation->whereDate('created_at', Carbon::now());
        if (!$this->isAdmin())
            $unitViolation = $unitViolation->whereUserId($this->user()->id);
        $unitViolation = $unitViolation->select(DB::raw("SUM(`count`) AS `count`"), 'violation_id');
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
        $unitOfficer = UnitOfficer::whereUnitId($request->unit_id)->orWhere('user_id', $request->user_id)->orderByDesc('id')->first();
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
