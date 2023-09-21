<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\RateModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RatesController extends Controller
{
  // Controller logic goes here
  public function __construct()
  {
      // Constructor logic goes here
  }

  public function hourly() {
    $data['rate_list'] = DB::table('category as c')
      ->leftJoin('rate as r', 'c.id', '=', 'r.category')
      ->select('c.name', 'r.*')
      ->where('c.deleted', '=', 0)
      ->get();
    return view('rates.hourly', $data);
  }

  public function hourly_update(Request $request) {
    $data = $request->input('data');
    foreach($data as $item) {
      $rate = RateModel::find($item['id']);
      if ($rate) {  // if record with that id exists
        $rate->hourly = $item['hourly'];
        $rate->hourly_2 = $item['hourly_2'];
        $rate->hourly_3 = $item['hourly_3'];
        $rate->hourly_4 = $item['hourly_4'];
        $rate->hourly_sd = $item['hourly_sd'];
        $rate->hourly_da = $item['hourly_da'];
        $rate->save();  // save the updated record
      }
      else  // if record with that id does not exist
        return response()->json(['success' => false, 'code' => 402]);
    }
    return response()->json(['success' => true, 'code' => 200]);
  }
  public function dailyRentCar() {
      return view('rates.dailyRentCar');
  }

  public function insuranceRates() {
      return view('rates.insuranceRates');
  }

  public function rateCalculator() {
      return view('rates.rateCalculator');
  }
}