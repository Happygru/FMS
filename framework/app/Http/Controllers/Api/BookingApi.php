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
use App\Model\Bookings;
use App\Model\AddonModel;
use App\Model\VehicleModel;

class BookingApi extends Controller {
    public function get_addon_list(Request $request) {
        $data['data'] = AddonModel::all();
        $data['status'] = 'success';
        return response()->json($data);
    }

    public function create_booking(Request $request) {

    }

    public function get_vehicle_list() {
        $data['data'] = VehicleModel::leftJoin('vehicle_types as vt', 'vt.id', '=', 'vehicles.type_id')
                                ->select("vehicles.*", "vt.vehicletype")
                                ->get();
        $data['status'] = 'success';
        return response()->json($data);
    }

    public function get_booking_list(Request $request) {
        $user_id = $request->get('user');
        $bookings = Bookings::leftJoin('vehicles', 'bookings.vehicle_id', '=', 'vehicles.id')
                            ->leftJoin('bookings_meta', function ($join) {
                                $join->on('bookings_meta.booking_id', '=', 'bookings.id')
                                    ->where('bookings_meta.key', '=', 'vehicle_typeid');
                            })
                            ->leftJoin('vehicle_types', 'bookings_meta.value', '=', 'vehicle_types.id')
                            ->where('bookings.customer_id', $user_id)
                            ->select("bookings.*")
                            ->get();
        $data['status'] = 'failed';
        $data['data'] = $bookings;
        return response()->json($data);
    }

    public function get_thirdparty_vehicles(Request $request) {
        $data['data'] = VehicleModel::leftJoin('vehicle_types as vt', 'vt.id', '=', 'vehicles.type_id')
                                    ->where('vehicles.user_id', $request->get('user_id'))
                                    ->select("vehicles.*", "vt.vehicletype")
                                    ->get();
        $data['status'] = 'success';
        return response()->json($data);        
    }
}
