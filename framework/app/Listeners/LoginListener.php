<?php
/*
@copyright

Fleet Manager v6.4

Copyright (C) 2017-2023 Hyvikk Solutions <https://hyvikk.com/> All rights reserved.
Design and developed by Hyvikk Solutions <https://hyvikk.com/>

 */
namespace App\Listeners;

use Artisan;

class LoginListener {

	public function __construct() {

	}

	public function handle($event) {

		// Artisan::call('notification:generate');
		Artisan::call('schedule:run');
	}
}
