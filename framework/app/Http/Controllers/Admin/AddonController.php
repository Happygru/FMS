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

class AddonController extends Controller {
  public function __construct() {

  }

  public function index() {
    $data['addon_list'] = AddonModel::where('deleted', 0)->get();
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

  public function addon_create(Request $request) {
      // Get the file from the request
      $file = $request->file('image');

      // Generate a new filename
      $newFileName = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

      // Check if a record with the same name already exists
      $existingService = AddonModel::firstWhere('name', $request->input('name'));
      if ($existingService) {
          // Return a response indicating that the name is already taken
          return response()->json(['success' => false, 'code' => 402]);
      }

      // Store the file in the 'uploads' disk, in the 'uploads' directory
      $uploads_dir = 'uploads/addons';
      $file->move($uploads_dir, $newFileName);

      // Create a new BookingService
      $addon = new AddonModel;

      // Set the properties
      $addon->image = $newFileName;  // Store the path of the uploaded file
      $addon->name = $request->input('name');
      $addon->description = $request->input('description');
      $addon->price = $request->input('price');
      $addon->type = $request->input('type');

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

    // Get the file from the request
    $file = $request->file('image');

    if ($file) {
        // If a file was provided, generate a new filename and store the file
        $newFileName = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
        $path = $file->move('uploads/addons/', $newFileName);

        $addon->image = $newFileName;
    }

    $addon->name = $request->input('name');
    $addon->description = $request->input('description');
    $addon->price = $request->input('price');
    $addon->type = $request->input('type');

    $addon->save();

    return response()->json(['success' => true, 'code' => 200]);
  }

  public function get_addon_list(Request $request) {
    $data = AddonModel::where('type', $request->type)->get();
    return response()->json(['success' => true, 'code' => 200, 'data' => $data]);
  }
}