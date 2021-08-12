<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    { 
        if (Hash::check($request->input('password'), auth()->user()->password))
        {
           if ($request->input('password_new') == $request->input('password_confirm')) {
                $user = User::FindOrFail($request->input('id_user'));
                $user->password = Hash::make($request->input('password_new'));
                $res = $user->save();
            if ($res) {
                return response()->json(true);
            } else {
                return response()->json(false);
            }
            
           } else {
            return response()->json('diferents');
           }
           
        }else {
            return response()->json('diferent');
        }
    }
}
