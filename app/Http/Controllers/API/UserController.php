<?php
namespace App\Http\Controllers\API;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Integer;
use \Validator;
use \App\Models\Doctor;
class UserController extends Controller
{
    public $successStatus = 200;
    /**
     * Authentication API
     *
     * @return JsonResponse
     */
    public function login(){
        $validator = Validator::make(request()->all(),[
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);
        if($validator->fails())
        {
            return response()->json(['error' => $validator->errors()], 401);
        }
        else
        {
            if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
                $user = Auth::user();
                $success['token'] =  $user->createToken('MyApp')-> accessToken;
                $user->save();
                return response()->json(['success' => $success], $this-> successStatus);
            }
            else{
                return response()->json(['error'=>'Unauthorised.'], 401);
            }
        }
    }

    /**
     * Register api
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
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        else{
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $user->patient()->create(); // Create patient object when creating user
            $success['token'] =  $user->createToken('Klinika')-> accessToken;
            $success['name'] =  $user->name;
            return response()->json(['success'=>$success], $this-> successStatus);
        }
    }
    /**
     * details api
     *
     * @return JsonResponse
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }
    /**
     * return list of all users + permissions;
     *
     * @return Response
     */
    public function list_users()
    {
        $res = [];

        $users = \App\Models\User::get();
        foreach($users as $user)
        {
            $user->is_doctor = 0;
            if(!isset($user->doctor()->id))
            {
                $user->is_doctor = 1;
            }

        }
        return response($users, 200);
    }
    /**
     * return list of all doctors
     *
     * @return Response
     */
    public function list_doctors()
    {
        $doctors = Doctor::get();
        foreach( $doctors as $doctor )
        {
            $usr = \App\Models\User::where('id','=',$doctor->user_id)->get(); $usr = $usr->first();
            $doctor->name = $usr->name;
        }
        return response($doctors, 200);
    }
    public function handlePermissionsAdmin($user_id, $tf)
    {
        $tf = intval($tf);
        if($tf !== 0 && $tf !== 1)
        {
            return response()->json(['status'=>'error', 'message' => 'tf must be 0 (revoke) or 1 (grant)'], 400);
        }
        try
        {
            $user = \App\Models\User::findOrFail($user_id);
        }
        catch (ModelNotFoundException $exception)
        {
            return response()->json($exception->getMessage(), 400);
        }
        $user->is_elevated = $tf;
        $user->save();
        return response()->json(['status'=> 'success','message'=>'Elevated permissions updated.'], 200);
    }
    public function handlePermissionsDoctor($user_id, $tf, Request $request)
    {
        $tf = intval($tf);
        if($tf === 1)
        {
            try
            {
                $usr = \App\Models\User::findOrFail($user_id);
            }
            catch (ModelNotFoundException $exception)
            {
                return response()->json($exception->getMessage(), 400);
            }
            if(isset($usr->doctor->user_id))
            {
                return response()->json(['status'=> 'error', 'message' => 'Already is doctor.'], 400);
            }
            else
            {
                // validate form data
                $validator = Validator::make($request->all(), [
                    'mobile_phone' => 'required'
                ]);
                if ($validator->fails()) {
                    return response()->json(['status'=> 'error', 'message'=>$validator->errors()], 401);
                }
                else{
                    $input = $request->all();
                    $mobile_phone = $input['mobile_phone'];
                    $doctor = new Doctor();
                    $doctor->user_id = $usr->id;
                    $doctor->mobile_phone = $mobile_phone;
                    $doctor->save();
                    return response()->json(['status'=> 'success','message'=>'Added to doctor group.'], 200);
                }
            }
        }
        if($tf == 0)
        {
            try
            {
                $usr = \App\Models\User::findOrFail($user_id);
            }
            catch (ModelNotFoundException $exception)
            {
                return response()->json($exception->getMessage(), 400);
            }
            if(!isset($usr->doctor->id))
            {
                return response()->json(['status'=> 'failed','message'=>'Already not a doctor.'], 400);
            }
            else
            {
                $usr->doctor()->delete();
                 return response()->json('Removed from doctor group.', 400);
            }
        }
        else
        {
            return response()->json(['error' => 'tf must be 0 (revoke) or 1 (grant)'], 401);
        }
    }
}
