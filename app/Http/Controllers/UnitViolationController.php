<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitViolationRequest;
use App\Http\Requests\UnitViolationUpdateRequest;
use App\Models\UnitViolation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UnitViolationController extends MasterController
{

    public function store(UnitViolationRequest $request)
    {
        $issetUnitViolation = UnitViolation::whereDate('created_at', Carbon::now()->format('Y-m-d'))
            ->whereUserId($this->user()->id)
            ->whereUnitId($request->unit_id)
            ->whereViolationId($request->violation_id)->first();
        if ($issetUnitViolation)
            return response()->json(['msg' => 'تم تسجيل المخالفة سابقاً']);

        UnitViolation::create($request->all());
        return response()->json(['msg' => 'تم تسجيل المخالفة']);
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
