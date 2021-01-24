<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Validator;

class VisitController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required',
            'date' => 'required|unique:visits',
            'user_id' => 'required'        
        ]);
        if($validator->fails())
        {
            return response() -> json(['error' => $validator->errors()], 401);
        }
        else
        {
            $visit = new \App\Models\Visit($request->all());
            $visit->save();
            return response()  -> json(['success' => $visit], 201);
        }
    }
}
