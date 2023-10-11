<?php

/*
  @copyright

  Fleet Manager v6.4

  Copyright (C) 2017-2023 Hyvikk Solutions <https://hyvikk.com/> All rights reserved.
  Design and developed by Hyvikk Solutions <https://hyvikk.com/>

*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\AddonModel;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

class AddonController extends Controller {
  public function __construct() {
    
  }

  public function index() {
    $data['addon_list'] = AddonModel::all();
    return view('addon.index', $data);
  }

  public function create() {
    return view('addon.create');
  }

  public function edit($id) {
    $addon = AddonModel::find($id);
    if($addon) {
      $data['addon'] = $addon;
      return view('addon.edit', $data);
    } else {
      return redirect()->back()->with('error', 'No service found with the specified id.');
    }
  }

  public function add_create(Request $request) {
      // Check if a record with the same name already exists
      $existingService = AddonModel::firstWhere('description', $request->input('description'));
      if ($existingService) {
          // Return a response indicating that the name is already taken
          return response()->json(['success' => false, 'code' => 402]);
      }
      // Create a new BookingService
      $addon = new AddonModel;

      // Set the properties
      $addon->description = $request->input('description');
      $addon->amount = $request->input('amount');
      $addon->addtototal = $request->input('addtototal');
      $addon->notes = $request->input('notes');

      // Save the new BookingService
      $addon->save();

      // Return a response
      return response()->json(['success' => true, 'code' => 200]);
  }
  public function addon_update(Request $request){
    // Find the record with the specified id
    $addon = AddonModel::find($request->input('id'));

    if (!$addon) {
        // If no record was found, return an error message
        return response()->json(['success' => false, 'code' => 402]);
    }

    $addon->description = $request->input('description');
    $addon->amount = $request->input('amount');
    $addon->addtototal = $request->input('addtototal');
    $addon->notes = $request->input('notes');

    $addon->save();

    return response()->json(['success' => true, 'code' => 200]);
  }

  public function get_addon_list(Request $request) {
    $data = AddonModel::where('type', $request->type)->get();
    return response()->json(['success' => true, 'data' => $data]);
  }

  public function addon_delete(Request $request) {
    $addon = AddonModel::find($request->id);
    $addon->delete();
    return response()->json(['success' => true]);
  }
}