<?php

/*
@copyright

Fleet Manager v6.4

Copyright (C) 2017-2023 Hyvikk Solutions <https://hyvikk.com/> All rights reserved.
Design and developed by Hyvikk Solutions <https://hyvikk.com/>

 */
namespace App\Http\Controllers\Auth;

use App;
use App\Http\Controllers\Controller;
use Hyvikk;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller {

	use ResetsPasswords;

	protected $redirectTo = 'admin/';

	public function __construct() {
		App::setLocale(Hyvikk::get('language'));
		$this->middleware('guest');
	}
}
