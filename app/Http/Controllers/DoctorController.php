<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use \Validator;
class DoctorController extends Controller
{
    /**
     * Register a new Doctor (and user)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'pesel' => 'required|min:8|unique:users',
            'specialization' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        else{
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $user['is_elevated'] = 0;
            $user['is_doctor'] = 1;
            $user->patient()->create(); // Create patient object when creating user
            $input_doctor = [
                'specialization'=> $input['specialization']
            ];
            $user->doctor()->create($input_doctor);
            $user->save();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['user'] = $user;
            //$success['doctor'] = $user->doctor;
            return response()->json(['success'=>$success]);
        }
    }
    public function list_doc_spec(Request $request)
    {
        $specialization = $request->all()['specialization'];
        $doctors = \App\Models\Doctor::all('user_id', 'specialization')->where('specialization', '=', $specialization);
        foreach($doctors as $doc)
        {
            $user_id = $doc->user_id;
            $user_name = User::find($doc->user_id)->name;
            $doc['name'] = $user_name;
            $visits = \App\Models\visit::where('doctor_id', '=', $user_id)->get('date');
            $doc['visits'] = $visits;
        }
        return response()->json($doctors, 201);
    }

}
