<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use \Validator;
class UserController extends Controller
{
    public $successStatus = 200;
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }
}
