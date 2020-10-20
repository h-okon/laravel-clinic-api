<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Medication;
use \Validator;

class MedicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medications = Medication::all();
        return response()->json($medications);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'gtin' => 'required|min:8',
        ]);
        if($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        else
        {
            $medication = new Medication($request->all());
            $medication->save();
            return response()->json([$medication], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $medication = \App\Models\Medication::findOrFail($id);
        }
        catch (ModelNotFoundException $exception)
        {
            return response()->json($exception->getMessage(), 400);
        }
        return response()->json($medication);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $medication = \App\Models\Medication::findOrFail($id);
        }
        catch (ModelNotFoundException $exception)
        {
            return response()->json($exception->getMessage(), 400);
        }
        $medication->name = $request->get('name');
        $medication->GTIN_code = $request->get('gtin_code');
        $medication->save();
        return response()->json($medication);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $medication = \App\Models\Note::findOrFail($id);
        }
        catch (ModelNotFoundException $exception)
        {
            return response()->json($exception->getMessage(), 400);
        }
        $medication->delete();
        return response() -> json([
            "message" => "Successfully deleted medication"
        ], 201);
    }
}
