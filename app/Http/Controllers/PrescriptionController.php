<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Validator;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $prescriptions = Prescription::all();
        return response()->json($prescriptions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store($request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required',
            'doctor_id' => 'required',
        ]);
        if($validator->fails())
        {
            return response() -> json(['error' => $validator->errors()], 401);
        }
        else
        {
            $prescription = new Prescription($request->all());
            $prescription->save();
            return response()  -> json([$prescription], 201);
        }
    }
    /**
     * Gets single prescription with given ID.
     * @param int
     */
    //
    public function  show($id)
    {
        try
        {
            $prescription = \App\Models\Prescription::findOrFail($id);
        }
        catch (ModelNotFoundException $exception)
        {
            return response()->json($exception->getMessage(), 400);
        }
        return response()->json($prescription);
    }
    // show prescription for user (all for given user)
    public function show_prescription_for_user($user_id)
    {
        try {
            $usr = \App\Models\User::findOrFail($user_id);
        }
        catch(ModelNotFoundException $exception)
        {
            return response()->json($exception->getMessage(), 400);
        }
        $prescriptions = \App\Models\Prescription::where('patient_id', $user_id)->get();
        return response()->json($prescriptions);
    }
    // show prescriptions for doctor (all prescriptions that have been issued by given doctor)
    public function show_prescription_for_doctor($doctor_id)
    {
        try{
            $doc = \App\Models\Doctor::where('findOrFail()
        }

    }
}