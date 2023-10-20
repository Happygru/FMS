<?php 


/*
@copyright

Fleet Manager v6.4

Copyright (C) 2017-2023 Hyvikk Solutions <https://hyvikk.com/> All rights reserved.
Design and developed by Hyvikk Solutions <https://hyvikk.com/>

 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Log;
use DataTables;
use Auth;
use App\Model\VehicleModel;

class ThirdManagersController extends Controller {

	public function __construct() {

	}

	public function index() {
		return view('thirdmanagers.index');
	}

	public function fetch_data(Request $request) {
	if ($request->ajax()) {

		$users = User::where("user_type", "T")->orderBy('users.id', 'desc');
		Log::activity($request, 'Fetch thirdparty managers datatable');
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
			->editColumn('name', function ($user) {
				return "<a href=" . route('thirdmanagers.show', $user->id) . ">$user->name</a>";
			})
			->addColumn('gender', function ($user) {
				return ($user->gender == 'M') ? "Male" : "Female";
			})
			->addColumn('address', function ($user) {
				return $user->addr;
			})
			->addColumn('action', function ($user) {
				return view('thirdmanagers.list-actions', ['row' => $user]);
			})
			->rawColumns(['action', 'check', 'name', 'avatar'])
			->make(true);
		}
	}

	public function edit(Request $request, $id) {
		$index['data'] = User::where('id', $id)->first();
		if($index['data']){
			Log::activity($request, 'View third party managers edit page');
			return view("thirdmanagers.edit", $index);
		}
		else
			return redirect()->back()->with('error', 'No user found with the specified id.');
	}

	public function ajax_update(Request $request) {
		$corporate = User::find($request->id);
		Log::activity($request, 'Update a thirdmanager');
		if (!$corporate) {
			return response()->json(['success' => false, 'code' => 402]);
		}

		// Set the properties
		$corporate->name = $request->input('name');
		$corporate->email = $request->input('email');
		$corporate->gender = $request->input('gender');
		$corporate->phone = $request->input('phone');
		$corporate->addr = $request->input('address');
		$corporate->location = $request->input('location');
		$corporate->save();
		Log::activity($request, 'Update a thirdmanager');
		return response()->json(['success' => true]);
	}

	public function create(Request $request) {
		Log::activity($request, 'View thirdmanager create page');
		return view("thirdmanagers.create");
	}

	public function ajax_store(Request $request) {
		$existingService = User::firstWhere('email', $request->input('email'));
		if ($existingService) {
			return response()->json(['success' => false, 'code' => 402]);
		}

		$corporate = new User;

		if($request->hasFile('avatar')) {
			$uploads_dir = 'uploads/avatars';
			$file = $request->file('avatar');
			$newFileName = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
			$file->move($uploads_dir, $newFileName);
			$corporate->avatar = $newFileName;
		}

		$corporate->name = $request->input('name');
		$corporate->email = $request->input('email');
		$corporate->gender = $request->input('gender');
		$corporate->phone = $request->input('phone');
		$corporate->addr = $request->input('address');
		$corporate->location = $request->input('location');

		$corporate->save();
		Log::activity($request, 'Create a thirdmanager');
		return response()->json(['success' => true]);
	}

	public function show(Request $request, $id) {
		$index['customer'] = User::where('id', $id)->first();
		if($index['customer']){
			Log::activity($request, 'View customer detail page');
			return view("thirdmanagers.show", $index);
		}
		else
			return redirect()->back()->with('error', 'No user found with the specified id.');
	}

	public function fetch_vehicle_data(Request $request) {
		if ($request->ajax()) {

			$user = Auth::user();
			if ($user->group_id == null || $user->user_type == "S") {
				$vehicles = VehicleModel::select('vehicles.*', 'users.name as name')->where('vehicles.user_id', $request->id);
			} else {
				$vehicles = VehicleModel::select('vehicles.*')->where('vehicles.group_id', $user->group_id)->where('vehicles.user_id', $request->id);
			}
			$vehicles = $vehicles
				->leftJoin('driver_vehicle', 'driver_vehicle.vehicle_id', '=', 'vehicles.id')
				->leftJoin('users', 'users.id', '=', 'driver_vehicle.driver_id')
				->leftJoin('users_meta', 'users_meta.id', '=', 'users.id')
				->groupBy('vehicles.id');

			$vehicles->with(['group', 'types', 'drivers']);

			return DataTables::eloquent($vehicles)
				->addColumn('check', function ($vehicle) {
					$tag = '<input type="checkbox" name="ids[]" value="' . $vehicle->id . '" class="checkbox" id="chk' . $vehicle->id . '" onclick=\'checkcheckbox();\'>';

					return $tag;
				})
				->editColumn('vehicle_image', function ($vehicle) {
					$src = ($vehicle->vehicle_image != null)?asset('uploads/vehicles/' . $vehicle->vehicle_image): asset('assets/images/vehicle.jpeg');

					return '<img src="' . $src . '" height="70px" width="90px">';
				})
				->addColumn('make', function ($vehicle) {
					return ($vehicle->make_name) ? $vehicle->make_name : '';
				})
				->addColumn('model', function ($vehicle) {
					return ($vehicle->model_name) ? $vehicle->model_name : '';
				})
				->addColumn('displayname', function ($vehicle) {
					return ($vehicle->type_id) ? $vehicle->types->displayname : '';
				})
				->addColumn('color', function ($vehicle) {
					return ($vehicle->color_name) ? $vehicle->color_name : '';
				})
				->editColumn('license_plate', function ($vehicle) {
					return $vehicle->license_plate;
				})
				->addColumn('group', function ($vehicle) {
					return ($vehicle->group_id) ? $vehicle->group->name : '';
				})
				->addColumn('LXBXH', function ($vehicle) {
					$LBH = ($vehicle->length) ? $vehicle->length . ' X ' : '';
					$LBH .= ($vehicle->breadth) ? $vehicle->breadth . ' X ' : '';
					$LBH .= $vehicle->height;
					return $LBH;
				})
				->addColumn('weight', function ($vehicle) {
					return $vehicle->weight;
				})
				->addColumn('in_service', function ($vehicle) {
					return ($vehicle->in_service) ? "YES" : "NO";
				})
				->filterColumn('in_service', function ($query, $keyword) {
					$query->whereRaw("IF(in_service = 1, 'YES', 'NO') like ?", ["%{$keyword}%"]);
				})
				->addColumn('action', function ($vehicle) {
					return view('vehicles.list-actions', ['row' => $vehicle]);
				})
				->addIndexColumn()
				->rawColumns(['vehicle_image', 'action', 'check'])
				->make(true);
		}
	}

}

?>