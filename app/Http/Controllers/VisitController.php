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
    public function index_for_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if($validator->fails())
            return response()->json(['error' => $validator->errors()], 405);
        else 
        {
            $visits = \App\Models\Visit::where('user_id', '=', $request->all()['user_id'])
                -> orWhere('doctor_id', '=', $request->all()['user_id'])->get(['date', 'doctor_id']);
            foreach($visits as $v)
            {
                $name = \App\Models\User::find($v['doctor_id'])->name;
                $specialization = \App\Models\Doctor::where('user_id', $v['doctor_id'])->get('specialization');
                $v['doctor_name'] = $name;
                $v['specialization'] = $specialization[0]->specialization;
            }
            return response()->json($visits, 200);
        }
    }
}
?>
