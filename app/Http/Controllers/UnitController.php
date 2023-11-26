<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitOfficerRequest;
use App\Http\Requests\UnitRequest;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
use App\Models\UnitOfficer;
use App\Models\UnitViolation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UnitController extends MasterController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UnitResource::collection(Unit::all());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitRequest $request)
    {
        Unit::create($request->all());
        return response()->json(['msg' => 'تم اضافة الوحدة']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        $unitViolation = UnitViolation::whereUnitId($unit->id);
        if (!$this->isAdmin())
            $unitViolation->whereUserId($this->user()->id)->get();
        return $unitViolation->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        return $unit->update($request->all());
    }

    public function setUnitOfficer(UnitOfficerRequest $request)
    {
        $unitOfficer = UnitOfficer::whereUserId($request->user_id)->orderByDesc('id')->first();
        if ($unitOfficer)
            $unitOfficer->update(['expires_at' => Carbon::now()]);
        UnitOfficer::create($request->all());
        return response()->json(['msg' => 'تمت العملية بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return response()->json(['msg' => 'تم حذف الوحدة']);
    }
}
