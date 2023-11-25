<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function user(){
        return auth('sanctum')->user();
    }
    public function isAdmin(){
        return $this->user() ? $this->user()->hasRole('admin') : null;
    }
    public function response($condition = null, $data = null, $error_message = 'Failed Request', $failed_status = 403)
    {
        if (isset($condition))
            return response()->json($data, 200);
        return response()->json($error_message, $failed_status);
    }
}
