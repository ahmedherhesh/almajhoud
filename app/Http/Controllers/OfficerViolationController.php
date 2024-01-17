<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfficerViolationRequest;
use App\Http\Requests\OfficerViolationUpdateRequest;
use App\Http\Resources\OfficersViolationResource;
use App\Http\Resources\OfficerViolationResource;
use App\Models\OfficerViolation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficerViolationController extends MasterController
{
    public function index(Request $request)
    {
        $officersViolation = OfficerViolation::query();
        if ($request->from)
            $officersViolation->whereDate('created_at', '>=', $request->from);
        if ($request->to)
            $officersViolation->whereDate('created_at', '<=', $request->to);
        if (!$request->from && !$request->to)
            $officersViolation->whereDate('created_at', Carbon::now());
        $officersViolation = $officersViolation->select(DB::raw("SUM(`count`) AS `count`"), 'violation_id')
            ->groupBy('violation_id')->get();
        return response()->json([
            'status' => 200,
            'data' => OfficersViolationResource::collection($officersViolation)
        ]);
    }
    public function show(Request $request, User $user)
    {
        $officerViolation = OfficerViolation::query();
        if ($request->from)
            $officerViolation->whereDate('created_at', '>=', $request->from);
        if ($request->to)
            $officerViolation->whereDate('created_at', '<=', $request->to);
        if (!$request->from && !$request->to)
            $officerViolation->whereDate('created_at', Carbon::now());
        if (!$this->isAdmin())
            $officerViolation = $officerViolation->whereUserId($this->user()->id);
        else $officerViolation = $officerViolation->whereUserId($user->id);
        $officerViolation = $officerViolation->get();
        return response()->json([
            'status' => 200,
            'data' => OfficerViolationResource::collection($officerViolation)
        ]);
    }
    public function store(OfficerViolationRequest $request)
    {
        $issetOfficerViolation = OfficerViolation::whereDate('created_at', Carbon::now()->format('Y-m-d'))
            ->whereUserId($this->user()->id)
            ->whereViolationId($request->violation_id)->first();
        if ($issetOfficerViolation)
            return response()->json(['status' => 400, 'msg' => 'تم تسجيل المخالفة سابقاً']);

        OfficerViolation::create($request->all());
        return response()->json(['status' => 200, 'msg' => 'تم تسجيل المخالفة']);
    }

    public function update(OfficerViolationUpdateRequest $request, $id)
    {
        $officerViolation = OfficerViolation::find($id);
        if (!$officerViolation)
            return response()->json(['status' => 400, 'msg' => 'عفواً هذه المخالفة غير متوفرة']);

        if ($officerViolation->cant_edit_at <= Carbon::now() && !$this->isAdmin())
            return response()->json(['status' => 400, 'msg' => 'انتهى وقت التعديل على هذه المخالفة']);

        $officerViolation->update($request->only('count'));
        return response()->json(['status' => 200, 'msg' => 'تم تحديث المخالفة']);
    }

    public function destroy($id)
    {
        $officerViolation = OfficerViolation::whereId($id);
        if (!$officerViolation->first())
            return response()->json(['status' => 400, 'msg' => 'عفواً هذه المخالفة غير متوفرة']);

        if ($officerViolation->first()->cant_edit_at <= Carbon::now() && !$this->isAdmin())
            return response()->json(['status' => 400, 'msg' => 'انتهى وقت التعديل على هذه المخالفة']);

        if (!$this->isAdmin())
            $officerViolation = $officerViolation->whereUserId($this->user()->id);
        $officerViolation = $officerViolation->first();
        if ($officerViolation)
            $officerViolation->delete();
        return response()->json(['status' => 200, 'msg' => 'تم حذف المخالفة']);
    }
}
