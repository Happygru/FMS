<?php

/*
@copyright

Fleet Manager v6.4

Copyright (C) 2017-2023 Hyvikk Solutions <https://hyvikk.com/> All rights reserved.
Design and developed by Hyvikk Solutions <https://hyvikk.com/>

 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Model\User;

class AuthApi extends Controller {
	// public function login(Request $request) {
	// 	$email = $request->get("email");
	// 	$password = $request->get("password");
	// 	$res['status'] = "success";
	// 	if (Login::attempt(['email' => $email, 'password' => $password])) {
	// 		$res['api_token'] = Login::user()->api_token;
	// 	} else {
	// 		$res['status'] = "failed";
	// 	}
	// 	return response()->json($res);
	// }

	public function login(Request $request) {
		$credentials = $request->only(['email', 'password']);
		$res['status'] = 'success';
		if(Auth::attempt($credentials)) {
			$user = Auth::user();
			$res['user'] = $user;
			$res['message'] = 'Welcome to login!';
		} else {
			$res['status'] = 'failed';
			$res['message'] = 'The email or password is incorrect.';
		}
		return response()->json($res);
	}

	public function register(Request $request) {
		$email = $request->get('email');
		$user = User::where('email', $email)->get();
		if(count($user) > 0) {
			$res['status'] = 'failed';
			$res['message'] = 'The email already exists.';
		} else {
			$data = $request->all();
			$data['password'] = Hash::make($request->password); // Hashing the password
			$user = User::create($data);
			$res['status'] = 'success';
		}
		return response()->json($res);
	}

	public function update_password(Request $request) {
		$old_password = $request->get('old_password');
		$new_password = $request->get('new_password');
		$user_id = $request->get('id');
	
		// Find the user
		$user = User::find($user_id);
	
		// Check if user exists
		if(!$user) {
			return response()->json(['status' => 'failed', 'message' => 'User not found']);
		}
	
		// Check if the old password is correct
		if (!Hash::check($old_password, $user->password)) {
			return response()->json(['status' => 'failed', 'message' => 'Old password is incorrect']);
		}
	
		// Update the password
		$user->password = Hash::make($new_password);
		$user->save();
	
		// Return a success message
		return response()->json(['status' => 'success', 'message' => 'Password updated successfully']);
	}

	public function update_profile(Request $request) {
		// Retrieve the user id from the request
		$user_id = $request->get('id');
	
		// Find the user
		$user = User::find($user_id);
	
		// Check if user exists
		if(!$user) {
			return response()->json(['status' => 'failed', 'message' => 'User not found']);
		}
	
		// Update the user details
		$user->update($request->except('id'));
	
		// Return a success message
		return response()->json(['status' => 'success', 'message' => 'Profile updated successfully']);
	}
}
