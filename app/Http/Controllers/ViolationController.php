<?php

namespace App\Http\Controllers;

use App\Http\Requests\ViolationRequest;
use App\Http\Resources\ViolationResource;
use App\Models\Violation;

class ViolationController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 200, 'data' => ViolationResource::collection(Violation::all())]);
    }
    public function store(ViolationRequest $request)
    {
        Violation::create($request->all());
        return response()->json(['status' => 200, 'msg' => 'تم اضافة المخالفة']);
    }

    public function update(ViolationRequest $request, Violation $violation)
    {
        $violation->update($request->all());
        return response()->json(['status' => 200, 'msg' => 'تم تحديث المخالفة']);
    }

    public function destroy(Violation $violation)
    {
        if ($violation->unitViolation)
            return response()->json(['status' => 400, 'msg' => 'تم تسجيل مخالفات تحت مسمى هذه المخالفه من قبل لذلك لا يمكن حذفها']);
        $violation->delete();
        return response()->json(['status' => 200, 'msg' => 'تم حذف المخالفة']);
    }
}
