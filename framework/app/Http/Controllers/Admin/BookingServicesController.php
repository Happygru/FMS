<?php

/*
@copyright

Fleet Manager v6.4

Copyright (C) 2017-2023 Hyvikk Solutions <https://hyvikk.com/> All rights reserved.
Design and developed by Hyvikk Solutions <https://hyvikk.com/>

 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingServicesRequest;
use App\Model\BookingServicesModel;

class BookingServicesController extends Controller {
    public function __construct() {

    }

    public function index() {
        return view('booking_services.index');
    }

    public function create() {
        return view('booking_services.create');
    }
}