<?php

/*
@copyright

Fleet Manager v6.4

Copyright (C) 2017-2023 Hyvikk Solutions <https://hyvikk.com/> All rights reserved.
Design and developed by Hyvikk Solutions <https://hyvikk.com/>

 */

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends FormRequest {

	public function authorize() {
		if (Auth::user()->user_type == "S" || Auth::user()->user_type == "O") {
			return true;
		} else {
			abort(404);
		}
	}

	public function rules() {
		if ($this->request->has("edit")) {
			return [

				'first_name' => 'required',
				'last_name' => 'required',
				'address' => 'required',
				'phone' => 'required|numeric',
				'email' => 'required|email|unique:users,email,' . \Request::get("id"),
				'start_date' => 'date|date_format:Y-m-d',
				'issue_date' => 'date|date_format:Y-m-d',
				'end_date' => 'nullable|date|date_format:Y-m-d',
				'exp_date' => 'required|date|date_format:Y-m-d',
				'driver_image' => 'nullable|mimes:jpg,png,jpeg',
				'license_image' => 'nullable|mimes:jpg,png,jpeg',
				'documents.*' => 'nullable|mimes:jpg,png,jpeg,pdf,doc,docx',
				'driver_commision_type' => 'required',
				'driver_commision' => 'required|numeric',
			];
		} else {
			return [

				'first_name' => 'required',
				'last_name' => 'required',
				'address' => 'required',
				'phone' => 'required|numeric',
				'email' => 'required|email|unique:users,email,' . \Request::get("id"),
				'exp_date' => 'required|date|date_format:Y-m-d|after:tomorrow',
				'start_date' => 'date|date_format:Y-m-d',
				'issue_date' => 'date|date_format:Y-m-d',
				'end_date' => 'nullable|date|date_format:Y-m-d',
				'driver_image' => 'nullable|mimes:jpg,png,jpeg',
				'license_image' => 'nullable|mimes:jpg,png,jpeg',
				'documents' => 'nullable|mimes:jpg,png,jpeg,pdf,doc,docx',
				'driver_commision_type' => 'required',
				'driver_commision' => 'required|numeric',
			];
		}
	}
}
