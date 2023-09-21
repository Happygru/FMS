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
    $data['rate_list'] = DB::table('category as c')
      ->leftJoin('rate as r', 'c.id', '=', 'r.category')
      ->select('c.name', 'r.*')
      ->where('c.deleted', '=', 0)
      ->get();
    return view('rates.dailyRentCar', $data);
  }

  public function dailyRentCar_update(Request $request) {
    $data = $request->input('data');
    foreach($data as $item) {
      $rate = RateModel::find($item['id']);
      if ($rate) {  // if record with that id exists
        $rate->wdwa_1_2 = $item['wdwa_1_2'];
        $rate->wdwa_1_2_sd = $item['wdwa_1_2_sd'];
        $rate->wdwa_3_6 = $item['wdwa_3_6'];
        $rate->wdwa_3_6_sd = $item['wdwa_3_6_sd'];
        $rate->wdwa_7_15 = $item['wdwa_7_15'];
        $rate->wdwa_7_15_sd = $item['wdwa_7_15_sd'];
        $rate->wdwa_16_30 = $item['wdwa_16_30'];
        $rate->wdwa_16_30_sd = $item['wdwa_16_30_sd'];
        $rate->wdwa_dka = $item['wdwa_dka'];
        $rate->wdwa_dkr = $item['wdwa_dkr'];
        $rate->save();  // save the updated record
      }
      else  // if record with that id does not exist
        return response()->json(['success' => false, 'code' => 402]);
    }
    return response()->json(['success' => true, 'code' => 200]);   
  }

  public function insurance_update(Request $request) {
    $data = $request->input('data');
    foreach($data as $item) {
      $rate = RateModel::find($item['id']);
      if ($rate) {  // if record with that id exists
        $rate->ins_1_2 = $item['ins_1_2'];
        $rate->ins_3_6 = $item['ins_3_6'];
        $rate->ins_7_15 = $item['ins_7_15'];
        $rate->ins_16_30 = $item['ins_16_30'];
        $rate->save();  // save the updated record
      }
      else  // if record with that id does not exist
        return response()->json(['success' => false, 'code' => 402]);
    }
    return response()->json(['success' => true, 'code' => 200]);
  }

  public function insuranceRates() {
    $data['rate_list'] = DB::table('category as c')
      ->leftJoin('rate as r', 'c.id', '=', 'r.category')
      ->select('c.name', 'r.*')
      ->where('c.deleted', '=', 0)
      ->get();
    return view('rates.insuranceRates', $data);
  }

  public function rateCalculator() {
      return view('rates.rateCalculator');
  }
}