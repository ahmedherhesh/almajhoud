<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitViolationRequest;
use App\Http\Requests\UnitViolationUpdateRequest;
use App\Http\Resources\UnitsViolationResource;
use App\Models\UnitViolation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitViolationController extends MasterController
{
    public function index(Request $request)
    {
        $unitsViolation = UnitViolation::query();
        if ($request->from)
            $unitsViolation->whereDate('created_at', '>=', $request->from);
        if ($request->to)
            $unitsViolation->whereDate('created_at', '<=', $request->to);
        if (!$request->from && !$request->to)
            $unitsViolation->whereDate('created_at', Carbon::now());
        if (!$this->isAdmin())
            $unitsViolation = $unitsViolation->whereUserId($this->user()->id);
        $unitsViolation = $unitsViolation->select(DB::raw("SUM(`count`) AS `count`"), 'violation_id')
            ->groupBy('violation_id')->get();
        return response()->json([
            'status' => 200,
            'data' => UnitsViolationResource::collection($unitsViolation)
        ]);
    }

    public function store(UnitViolationRequest $request)
    {
        $issetUnitViolation = UnitViolation::whereDate('created_at', Carbon::now()->format('Y-m-d'))
            ->whereUserId($this->user()->id)
            ->whereUnitId($request->unit_id)
            ->whereViolationId($request->violation_id)->first();
        if ($issetUnitViolation)
            return response()->json(['status' => 400, 'msg' => 'تم تسجيل المخالفة سابقاً']);

        UnitViolation::create($request->all());
        return response()->json(['status' => 200, 'msg' => 'تم تسجيل المخالفة']);
    }

    public function update(UnitViolationUpdateRequest $request, $id)
    {
        $unitViolation = UnitViolation::find($id);
        if (!$unitViolation)
            return response()->json(['msg' => 'عفواً هذه المخالفة غير متوفرة']);

        if ($unitViolation->cant_edit_at <= Carbon::now() && !$this->isAdmin())
            return response()->json(['msg' => 'انتهى وقت التعديل على هذه المخالفة']);

        $unitViolation->update($request->only('count'));
        return response()->json(['msg' => 'تم تحديث المخالفة']);
    }

    public function destroy($id)
    {
        $unitViolation = UnitViolation::whereId($id);
        if ($unitViolation->first())
            return response()->json(['msg' => 'عفواً هذه المخالفة غير متوفرة']);

        if ($unitViolation->first()->cant_edit_at <= Carbon::now() && !$this->isAdmin())
            return response()->json(['msg' => 'انتهى وقت التعديل على هذه المخالفة']);

        if (!$this->isAdmin())
            $unitViolation = $unitViolation->whereUserId($this->user()->id);
        $unitViolation = $unitViolation->first();
        if ($unitViolation)
            $unitViolation->delete();
    }
}
