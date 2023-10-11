<?php

/*
@copyright

Fleet Manager v6.4

Copyright (C) 2017-2023 Hyvikk Solutions <https://hyvikk.com/> All rights reserved.
Design and developed by Hyvikk Solutions <https://hyvikk.com/>

 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingQuotationModel extends Model {
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = "booking_quotation";
	protected $fillable = [
		'booking_id',
		'customer_id',
		'user_id',
		'source',
		'vehicle_id',
		'branch_id',
		'service_type',
		'reservice_type',
		'addon_id',
		'addon_quantity',
		'driver_id',
		'pickup',
		'dropoff',
		'duration',
		'pickup_addr',
		'dest_addr',
		'note',
		'travellers',
		'hours',
		'distance',
		'tax_percent',
		'tax_charge',
		'tax_total',
		'status',
		'airport_pickup',
		'airport_pickup_details',
		'airport_date',
		'final_destination',
		'destination_outside',
		'payment',
		'track_time',
		'ride_status'
	];

	public function vehicle() {
		return $this->hasOne("App\Model\VehicleModel", "id", "vehicle_id")->withTrashed();
	}

	public function customer() {
		return $this->hasOne("App\Model\User", "id", "customer_id")->withTrashed();
	}

	public function driver() {
		return $this->hasOne("App\Model\User", "id", "driver_id")->withTrashed();
	}

	public function user() {
		return $this->hasOne("App\Model\User", "id", "user_id")->withTrashed();
	}

}
