<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'doctor_id' => 'required',
            'date' => 'required'
        ]);
        if($validator->fails())
        {
            return response() -> json(['error' => $validator->errors()], 401);
        }
        else
        {
            $visit = new Visit($request->all());
            $visit->save();
            return response()  -> json(['success' => $visit], 201);
        }
    }
}
