<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validate=$request->validate([
                "email" => "required|email|unique:users,email",
                "password" => "required|confirmed|min:8",
                "phone_number" => "required|digits:10|unique:users,phone_number",
                "photo" => "mimes:jpg,png,jpeg|nullable",
                "name" => "required"
            ]);
            if ($request->has('photo')) {
                $file = $request->file('photo');
                $file_extension =  $file->getClientOriginalExtension();
                $file_name = time() . "." . $file_extension;
                $path = 'images/users/';
                $file->move($path, $file_name);
                $image_path = $path . $file_name;
            } else {
                $image_path = 'images/defulte.png';
            }

            
            $user = User::create([
                "email" => $request->email,
                "password" => bcrypt($request->password),
                "name" => $request->name,
                "phone_number" => $request->phone_number,
                'photo' => Url($image_path)
            ]);
        

            if ($user) {
                return response()->json(['status' => 'success', 'message' => 'Successfully inserted data'], 201);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    //{post} form_data login api 
    public function login(Request $request)
    {
        try {
            $validate=$request->validate([
                "email" => "required|email",
                "password" => "required|min:8",
            ]);
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json(['status' => 'error', 'message' => 'unbale login invalid'], 401);
            }
            $ver_email=DB::table('email_verification_tokens')->where('email', $request->email)->first();
            if($ver_email!=$validate['email']){
                $user = Auth::user();
                $token = $user->createToken('apiToken')->plainTextToken;
                return response()->json(['status' => 'success', 'token' => $token], 200);
                
            }
            else{
                return response()->json(['status' => 'error', 'message' => 'email not verified'], 400);

            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    //{get} show data api 
    public function profile()
    {
        try {
            $user = Auth::user();
            if ($user) {
                return response()->json(['status' => 'sucsses', 'message' => 'true user profile', 'data' => $user], 200);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    //{post} delete token ,,, logout api 
    public function logout()
    {
        try {
            $user = Auth::user();
            if ($user) {
                $user->currentAccessToken()->delete();
                return response()->json(['status' => 'sucsses', 'message' => 'logout sucssesfully'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|confirmed|min:8',
            ]);

            $user = Auth::user();

            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
            }

            if (!Hash::check($validatedData['old_password'], $user->password)) {
                return response()->json(['status' => 'error', 'message' => 'Old password does not match'], 400);
            }

            $user->update(['password' => bcrypt($validatedData['new_password'])]);

            return response()->json(['status' => 'success', 'message' => 'Password changed successfully'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => $e->errors()], 400);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    public function changePhoneNumber(Request $request){
        try{
        $validatedData = $request->validate([
            'password' => 'required',
            "phone_number" => "required|digits:10|unique:users,phone_number",
        ]);
        $user=Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
        }
        if (!Hash::check($validatedData['password'], $user->password)) {
            return response()->json(['status' => 'error', 'message' => ' password does not Valid'], 400);
        }
        $user->update(['phone_number' => $validatedData['phone_number']]);
        return response()->json(['status' => 'success', 'message' => 'PhoneNumber changed successfully'], 200);

    }
    catch(Exception $e){
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
}
