<?php

namespace App\Http\Controllers;

use App\Http\Requests\ViolationRecordRequest;
use App\Models\ViolationRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ViolationRecordController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(ViolationRecordRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = $this->user()->id;
        return ViolationRecord::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return ViolationRecord::whereUnitId($id)->whereDate(Carbon::now()->date())->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ViolationRecord $violationRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ViolationRecord $violationRecord)
    {
        //
    }
}
