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
use Illuminate\Support\Facades\Storage;

class BookingServicesController extends Controller {
    public function __construct() {

    }

    public function index() {
        return view('booking_services.index');
    }

    public function create() {
        return view('booking_services.create');
    }

    public function edit($id) {
        // Find a record with the specified id
        $bookingService = BookingServicesModel::find($id);

        if ($bookingService) {
            // If a record was found, pass it to the view
            return view('booking_services.edit', ['service' => $bookingService]);
        } else {
            // If no record was found, you can redirect or show an error page
            return redirect()->back()->with('error', 'No service found with the specified id.');
        }
    }

    public function fetch_data() {
        $bookingServices = BookingServicesModel::all();
        return response()->json($bookingServices);
    }
    public function fetch_data_condition(Request $request) {
        $type = $request->get('service_type');
        $data = BookingServicesModel::where('type', $type)->get();
        return response()->json([ 'success' => true, 'data' => $data]);
    }

    public function delete_item(Request $request) {
        $bookingServices = BookingServicesModel::find($request->id);
        $bookingServices->delete();
        return response()->json($bookingServices);
    }

    public function create_item(Request $request) {
        // Get the file from the request
        $file = $request->file('icon');

        // Generate a new filename
        $newFileName = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

        // Check if a record with the same name already exists
        $existingService = BookingServicesModel::firstWhere('name', $request->input('name'));
        if ($existingService) {
            // Return a response indicating that the name is already taken
            return response()->json(['success' => false, 'code' => 402]);
        }

        // Store the file in the 'uploads' disk, in the 'uploads' directory
        $uploads_dir = 'uploads/services';
        $file->move($uploads_dir, $newFileName);

        // Create a new BookingService
        $bookingService = new BookingServicesModel;

        // Set the properties
        $bookingService->name = $request->input('name');
        $bookingService->description = $request->input('description');
        $bookingService->icon = $newFileName;  // Store the path of the uploaded file
        $bookingService->website = $request->input('website');
        $bookingService->backend = $request->input('backend');
        $bookingService->corporate = $request->input('corporate');

        // Save the new BookingService
        $bookingService->save();

        // Return a response
        return response()->json(['success' => true, 'code' => 200]);
    }

    public function update_item(Request $request) {
        // Find the record with the specified id
        $bookingService = BookingServicesModel::find($request->input('id'));

        if (!$bookingService) {
            // If no record was found, return an error message
            return response()->json(['success' => false, 'code' => 402]);
        }

        // Get the file from the request
        $file = $request->file('icon');

        if ($file) {
            // If a file was provided, generate a new filename and store the file
            $newFileName = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $path = $file->move('uploads/services/', $newFileName);

            // Update the icon field in the record
            $bookingService->icon = $newFileName;
        }

        // Update the other fields in the record
        $bookingService->name = $request->input('name');
        $bookingService->description = $request->input('description');
        $bookingService->website = $request->input('website');
        $bookingService->backend = $request->input('backend');
        $bookingService->corporate = $request->input('corporate');

        // Save the updated BookingService
        $bookingService->save();

        // Return a response
        return response()->json(['success' => true, 'code' => 200]);
    }
}