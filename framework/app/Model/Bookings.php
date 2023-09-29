<?php

/*
@copyright

Fleet Manager v6.4

Copyright (C) 2017-2023 Hyvikk Solutions <https://hyvikk.com/> All rights reserved.
Design and developed by Hyvikk Solutions <https://hyvikk.com/>

 */

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kodeine\Metable\Metable;

class Bookings extends Model {
	use HasFactory;
	use Metable;
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = "bookings";
	protected $metaTable = 'bookings_meta';
	protected $fillable = [
		'booking_id', 'customer_id', 'vehicle_id', 'user_id', 'service_type', 'reservation_type', 'addon_id', 'addon_quantity', 'driver_id', 'pickup', 'dropoff', 'pickup_addr', 'dest_addr', 'travellers', 'status', 'comment', 'dropoff_time', 'note', 'airport_pickup', 'airport_pickup_details', 'duration', 'tax', 'tax_total', 'airport_date', 'track_time', 'ride_status'
	];

	protected function getMetaKeyName() {
		return 'booking_id'; // The parent foreign key
	}

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

	// multivehicle test
	// function test1() {
	//     return $this->hasMany("App\Model\VehicleModel", "id", "v_id")->withTrashed();
	// }
	// function test() {
	//     return $this->belongsTo("App\Model\VehicleModel", "v_id", "id")->withTrashed();
	// }
}
