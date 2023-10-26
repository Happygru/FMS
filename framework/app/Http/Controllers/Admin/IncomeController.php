<?php

/*
@copyright

Fleet Manager v6.4

Copyright (C) 2017-2023 Hyvikk Solutions <https://hyvikk.com/> All rights reserved.
Design and developed by Hyvikk Solutions <https://hyvikk.com/>

 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncRequest;
use App\Model\DriverLogsModel;
use App\Model\IncCats;
use App\Model\IncomeModel;
use App\Model\VehicleModel;
use Auth;
use DB;
use Illuminate\Http\Request;

class IncomeController extends Controller {

	public function __construct() {
		// $this->middleware(['role:Admin']);
		$this->middleware('permission:Transactions add', ['only' => ['store']]);
		$this->middleware('permission:Transactions edit', ['only' => ['edit']]);
		$this->middleware('permission:Transactions delete', ['only' => ['bulk_delete', 'destroy']]);
		$this->middleware('permission:Transactions list');
	}

	public function index() {
		$data['date1'] = null;
		$data['date2'] = null;
		$user = Auth::user();
		if ($user->user_type == "D") {
			// $v = DriverLogsModel::where('driver_id',Auth::user()->id)->get();
			// $vehicle_ids = $v->pluck('vehicle_id')->toArray();
			// $data['vehicels'] = VehicleModel::whereId($v->pluck('vehicle_id'))->whereIn_service(1)->get();

			$vehicle_ids = auth()->user()->vehicles()->pluck('vehicle_id')->toArray();
			$data['vehicels'] = auth()->user()->vehicles()->with(['maker', 'vehiclemodel'])->whereIn_service(1)->get();
		} else {
			if ($user->group_id == null || $user->user_type == "S") {
				$data['vehicels'] = VehicleModel::whereIn_service(1)->get();
				$vehicle_ids = $data['vehicels']->pluck('id')->toArray();
			} else {
				$data['vehicels'] = VehicleModel::whereIn_service(1)->where('group_id', $user->group_id)->get();
				$vehicle_ids = $data['vehicels']->pluck('id')->toArray();
			}
		}
		$data['types'] = IncCats::get();
		$income = IncomeModel::with(['category'])->whereIn('vehicle_id', $vehicle_ids)->whereDate('date', DB::raw('CURDATE()'));
		$data['today'] = $income->get();
		$data['total'] = $income->sum('amount');
		return view("income.index", $data);
	}

	public function store(IncRequest $request) {
		IncomeModel::create([
			"vehicle_id" => $request->get("vehicle_id"),
			// "amount" => $request->get("revenue"),
			"amount" => $request->get("tax_total"),
			"user_id" => Auth::id(),
			"date" => $request->get('date'),
			"mileage" => $request->get("mileage"),
			"income_cat" => $request->get("income_type"),
			"tax_percent" => $request->tax_percent,
			"tax_charge_rs" => $request->tax_charge_rs,
		]);
		$v = VehicleModel::find($request->get("vehicle_id"));

		$v->mileage = $request->get("mileage");
		$v->save();
		return redirect()->route("income.index");
	}

	public function destroy(Request $request) {
		IncomeModel::find($request->get('id'))->delete();
		$user = Auth::user();
		if ($user->user_type == "D") {
			$v = DriverLogsModel::where('driver_id', Auth::user()->id)->get();
			$vehicle_ids = $v->pluck('vehicle_id')->toArray();
		} else {
			if ($user->group_id == null || $user->user_type == "S") {
				$vehicle_ids = VehicleModel::with(['metas'])->whereIn_service(1)->pluck('id')->toArray();
			} else {
				$vehicle_ids = VehicleModel::with(['metas'])->whereIn_service(1)->where('group_id', $user->group_id)->pluck('id')->toArray();
			}
		}
		$income = IncomeModel::whereIn('vehicle_id', $vehicle_ids)->whereDate('date', DB::raw('CURDATE()'));
		$data['today'] = $income->get();
		$data['total'] = $income->sum('amount');
		return view("income.ajax_income", $data);
		// return redirect()->route('income.index');
	}

	public function income_records(Request $request) {
		$data['date1'] = $request->date1;
		$data['date2'] = $request->date2;
		$user = Auth::user();
		if ($user->user_type == "D") {
			// $v = DriverLogsModel::where('driver_id',Auth::user()->id)->get();
			// $vehicle_ids = $v->pluck('vehicle_id')->toArray();
			// $data['vehicels'] = VehicleModel::with(['metas','maker','vehiclemodel'])
			// ->whereId($v->pluck('vehicle_id'))->whereIn_service(1)->get();
			$vehicle_ids = auth()->user()->vehicles()->pluck('vehicle_id')->toArray();
			$data['vehicels'] = auth()->user()->vehicles()->with(['maker', 'vehiclemodel'])->whereIn_service(1)->get();
		} else {
			if ($user->group_id == null || $user->user_type == "S") {
				$data['vehicels'] = VehicleModel::with(['metas'])
					->whereIn_service(1)->get();
				$vehicle_ids = $data['vehicels']->pluck('id')->toArray();
			} else {
				$data['vehicels'] = VehicleModel::with(['metas'])
					->whereIn_service(1)->where('group_id', $user->group_id)->get();
				$vehicle_ids = $data['vehicels']->pluck('id')->toArray();
			}
		}

		$data['types'] = IncCats::get();
		$data['today'] = IncomeModel::with(['category'])->whereIn('vehicle_id', $vehicle_ids)->whereBetween('date', [$request->get('date1'), $request->get('date2')])->get();
		$data['total'] = IncomeModel::whereIn('vehicle_id', $vehicle_ids)->whereDate('date', DB::raw('CURDATE()'))->sum('amount');

		return view("income.index", $data);
	}

	public function bulk_delete(Request $request) {
		IncomeModel::whereIn('id', $request->ids)->delete();
		return redirect('admin/income');
	}


	public function thirdparty(Request $request) {
		$data['date1'] = null;
		$data['date2'] = null;
		$user = Auth::user();
		if ($user->user_type == "D") {
			// $v = DriverLogsModel::where('driver_id',Auth::user()->id)->get();
			// $vehicle_ids = $v->pluck('vehicle_id')->toArray();
			// $data['vehicels'] = VehicleModel::whereId($v->pluck('vehicle_id'))->whereIn_service(1)->get();

			$vehicle_ids = auth()->user()->vehicles()->pluck('vehicle_id')->toArray();
			$data['vehicels'] = auth()->user()->vehicles()->with(['maker', 'vehiclemodel'])->whereIn_service(1)->get();
		} else {
			if ($user->group_id == null || $user->user_type == "S") {
				$data['vehicels'] = VehicleModel::whereIn_service(1)->where('group_id', 2)->get();
				$vehicle_ids = $data['vehicels']->pluck('id')->toArray();
			} else {
				$data['vehicels'] = VehicleModel::whereIn_service(1)->where('group_id', $user->group_id)->get();
				$vehicle_ids = $data['vehicels']->pluck('id')->toArray();
			}
		}
		$data['types'] = IncCats::get();
		$income = IncomeModel::with(['category'])->whereIn('vehicle_id', $vehicle_ids)->whereDate('date', DB::raw('CURDATE()'));
		$data['today'] = $income->get();
		$data['total'] = $income->sum('amount');
		return view("income.thirdparty", $data);
	}

	public function thirdparty_income_records(Request $request) {
		$data['date1'] = $request->date1;
		$data['date2'] = $request->date2;
		$user = Auth::user();
		if ($user->user_type == "D") {
			// $v = DriverLogsModel::where('driver_id',Auth::user()->id)->get();
			// $vehicle_ids = $v->pluck('vehicle_id')->toArray();
			// $data['vehicels'] = VehicleModel::with(['metas','maker','vehiclemodel'])
			// ->whereId($v->pluck('vehicle_id'))->whereIn_service(1)->get();
			$vehicle_ids = auth()->user()->vehicles()->pluck('vehicle_id')->toArray();
			$data['vehicels'] = auth()->user()->vehicles()->with(['maker', 'vehiclemodel'])->whereIn_service(1)->get();
		} else {
			if ($user->group_id == null || $user->user_type == "S") {
				$data['vehicels'] = VehicleModel::with(['metas'])
					->whereIn_service(1)->where('group_id', 2)->get();
				$vehicle_ids = $data['vehicels']->pluck('id')->toArray();
			} else {
				$data['vehicels'] = VehicleModel::with(['metas'])
					->whereIn_service(1)->where('group_id', $user->group_id)->get();
				$vehicle_ids = $data['vehicels']->pluck('id')->toArray();
			}
		}

		$data['types'] = IncCats::get();
		$data['today'] = IncomeModel::with(['category'])->whereIn('vehicle_id', $vehicle_ids)->whereBetween('date', [$request->get('date1'), $request->get('date2')])->get();
		$data['total'] = IncomeModel::whereIn('vehicle_id', $vehicle_ids)->whereDate('date', DB::raw('CURDATE()'))->sum('amount');

		return view("income.thirdparty", $data);		
	}
}
