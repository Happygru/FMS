<?php

/*
@copyright

Fleet Manager v6.4

Copyright (C) 2017-2023 Hyvikk Solutions <https://hyvikk.com/> All rights reserved.
Design and developed by Hyvikk Solutions <https://hyvikk.com/>

 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\BookingServicesModel;
use Illuminate\Http\Request;

class BookingServicesController extends Controller {
    public function __construct() {

    }

    public function index() {
        return view('booking_services.index');
    }

    public function create() {
        return view('booking_services.create');
    }

    public function fetch_data() {
        $bookingServices = BookingServicesModel::all();
        return response()->json($bookingServices);
    }

    public function delete_item(Request $request) {
        $bookingServices = BookingServicesModel::find($request->id);
        $bookingServices->delete();
        return response()->json($bookingServices);
    }
}