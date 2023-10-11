<?php

/*
@copyright

Fleet Manager v6.4

Copyright (C) 2017-2023 Hyvikk Solutions <https://hyvikk.com/> All rights reserved.
Design and developed by Hyvikk Solutions <https://hyvikk.com/>

 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customers as CustomerRequest;
use App\Http\Requests\ImportRequest;
use App\Imports\CustomerImport;
use App\Model\User;
use App\Model\Log;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class CustomersController extends Controller {
	public function __construct() {
		// $this->middleware(['role:Admin']);
		$this->middleware('permission:Customer add', ['only' => ['create']]);
		$this->middleware('permission:Customer edit', ['only' => ['edit']]);
		$this->middleware('permission:Customer delete', ['only' => ['bulk_delete', 'destroy']]);
		$this->middleware('permission:Customer list');
		$this->middleware('permission:Customer import', ['only' => ['importCutomers']]);
	}

	public function importCutomers(ImportRequest $request) {

		$file = $request->excel;
		$destinationPath = './assets/samples/'; // upload path
		$extension = $file->getClientOriginalExtension();
		$fileName = Str::uuid() . '.' . $extension;
		$file->move($destinationPath, $fileName);
		// dd($fileName);
		Excel::import(new CustomerImport, 'assets/samples/' . $fileName);

		// $excel = Importer::make('Excel');
		// $excel->load('assets/samples/' . $fileName);
		// $collection = $excel->getCollection()->toArray();
		// array_shift($collection);
		// // dd($collection);
		// foreach ($collection as $customer) {
		//     if ($customer[3] != null) {
		//         $id = User::create([
		//             "name" => $customer[0] . " " . $customer[1],
		//             "email" => $customer[3],
		//             "password" => bcrypt($customer[6]),
		//             "user_type" => "C",
		//             "api_token" => str_random(60),
		//         ])->id;
		//         $user = User::find($id);
		//         $user->first_name = $customer[0];
		//         $user->last_name = $customer[1];
		//         $user->address = $customer[5];
		//         $user->mobno = $customer[2];
		//         if ($customer[4] == "female") {
		//             $user->gender = 0;
		//         } else {
		//             $user->gender = 1;
		//         }
		//         $user->save();
		//         $user->givePermissionTo(['Bookings add','Bookings edit','Bookings list','Bookings delete']);
		//     }
		// }
		return back();
	}

	public function index(Request $request) {
		Log::activity($request, 'View customer page');
		return view("customers.index");
	}

	public function fetch_data(Request $request) {
		if ($request->ajax()) {

			$users = User::where("user_type", "C")->orderBy('users.id', 'desc');
			Log::activity($request, 'Fetch customers datatables');
			return DataTables::eloquent($users)
				->addColumn('check', function ($user) {
					$tag = '<input type="checkbox" name="ids[]" value="' . $user->id . '" class="checkbox" id="chk' . $user->id . '" onclick=\'checkcheckbox();\'>';
					return $tag;
				})
				->addColumn('mobno', function ($user) {
					return $user->phone;
				})
				->editColumn('avatar', function ($user) {
					return "<img src=".asset('uploads/avatars/')."/".($user->avatar ? $user->avatar : 'default.jpg')." style='width: 50px; height: 50px; border-radius: 50%;' />";
				})
				->addColumn('customer_type', function ($user) {
					return $user->customer_type == 'C' ? 'Corporate' : 'Individual';
				})
				->editColumn('name', function ($user) {
					return "<a href=" . route('customers.show', $user->id) . ">$user->name</a>";
				})
				->addColumn('gender', function ($user) {
					return ($user->gender == 'M') ? "Male" : "Female";
				})
				->addColumn('address', function ($user) {
					return $user->addr;
				})
				->addColumn('action', function ($user) {
					return view('customers.list-actions', ['row' => $user]);
				})
				->rawColumns(['action', 'check', 'name', 'avatar'])
				->make(true);
			//return datatables(User::all())->toJson();
		}
	}

	public function create(Request $request) {
		Log::activity($request, 'View customer create page');
		return view("customers.create");
	}
	public function store(CustomerRequest $request) {

		$id = User::create([
			"name" => $request->get("first_name") . " " . $request->get("last_name"),
			"email" => $request->get("email"),
			"password" => bcrypt("password"),
			"user_type" => "C",
			"api_token" => str_random(60),
		])->id;
		$user = User::find($id);
		$user->user_id = Auth::user()->id;
		$user->first_name = $request->get("first_name");
		$user->last_name = $request->get("last_name");
		$user->address = $request->get("address");
		$user->mobno = $request->get("phone");
		$user->gender = $request->get('gender');
		$user->save();
		$user->givePermissionTo(['Bookings add', 'Bookings edit', 'Bookings list', 'Bookings delete']);

		return redirect()->route("customers.index");
	}
	public function ajax_store(Request $request) {
		// Check if a record with the same name already exists
		$existingService = User::firstWhere('email', $request->input('email'));
		if ($existingService) {
			// Return a response indicating that the name is already taken
			return response()->json(['success' => false, 'code' => 402]);
		}


		$corporate = new User;

		if($request->hasFile('avatar')) {
			// Generate a new filename
			// Store the file in the 'uploads' disk, in the 'uploads' directory
			$uploads_dir = 'uploads/avatars';
			$file = $request->file('avatar');
			$newFileName = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
			$file->move($uploads_dir, $newFileName);
			$corporate->avatar = $newFileName;  // Store the path of the uploaded file
		}

		// Set the properties
		$corporate->name = $request->input('name');
		$corporate->email = $request->input('email');
		$corporate->gender = $request->input('gender');
		$corporate->phone = $request->input('phone');
		$corporate->addr = $request->input('address');
		$corporate->location = $request->input('location');
		$corporate->customer_type = $request->input('customer_type');
		$corporate->user_type = 'C';

		// Save the new BookingService
		$corporate->save();
		Log::activity($request, 'Create a customer account');
		return response()->json(['success' => true]);
	}

	public function show(Request $request, $id) {
		$index['customer'] = User::where('id', $id)->first();
		if($index['customer']){
			Log::activity($request, 'View customer detail page');
			return view("customers.show", $index);
		}
		else
			return redirect()->back()->with('error', 'No user found with the specified id.');
	}

	public function destroy(Request $request) {
		// User::find($request->get('id'))->get_detail()->delete();
		User::find($request->get('id'))->user_data()->delete();
		//$user = User::find($request->get('id'))->delete();
		$user = User::find($request->get('id'));
		$user->update([
			'email' => time() . "_deleted" . $user->email,
		]);
		$user->delete();
		Log::activity($request, 'Delete customer');

		return redirect()->route('customers.index');
	}

	public function edit(Request $request, $id) {
		$index['data'] = User::where('id', $id)->first();
		if($index['data']){
			Log::activity($request, 'View customer edit page');
			return view("customers.edit", $index);
		}
		else
			return redirect()->back()->with('error', 'No user found with the specified id.');
	}
	public function ajax_update(Request $request) {
		// Check if a record with the same name already exists
		$corporate = User::find($request->id);
		if (!$corporate) {
			// Return a response indicating that the name is already taken
			return response()->json(['success' => false, 'code' => 402]);
		}

		// Set the properties
		$corporate->name = $request->input('name');
		$corporate->email = $request->input('email');
		$corporate->gender = $request->input('gender');
		$corporate->phone = $request->input('phone');
		$corporate->addr = $request->input('address');
		$corporate->location = $request->input('location');
		$corporate->customer_type = $request->input('customer_type');

		// Save the new BookingService
		$corporate->save();
		Log::activity($request, 'Update a customer');
		return response()->json(['success' => true]);
	}

	public function bulk_delete(Request $request) {
		// dd($request->all());
		//User::whereIn('id', $request->ids)->delete();
		// return redirect('admin/customers');
		$users = User::whereIn('id', $request->ids)->get();
		foreach ($users as $user) {
			$user->update([
				'email' => time() . "_deleted" . $user->email,
			]);
			$user->delete();
		}

		return back();
	}
}
