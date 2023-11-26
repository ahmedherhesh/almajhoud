<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitOfficerRequest;
use App\Models\Unit;
use App\Models\UnitOfficer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Unit::all();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Unit::create($request->all());
        return response()->json(['msg' => 'تم اضافة الوحدة']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        return $unit->violations;
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
        $unitOfficer = UnitOfficer::whereUnitId($request->unit_id)->orderByDesc('id')->first();
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
