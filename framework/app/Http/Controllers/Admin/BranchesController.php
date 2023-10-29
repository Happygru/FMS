<?php

/*
  @copyright

  Fleet Manager v6.4

  Copyright (C) 2017-2023 Hyvikk Solutions <https://hyvikk.com/> All rights reserved.
  Design and developed by Hyvikk Solutions <https://hyvikk.com/>

*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\BranchModel;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchesController extends Controller {
  public function __construct() {

  }

  public function index() {
    $data['branches'] = DB::table('branch')
                          ->leftJoin('users', 'branch.manager', '=', 'users.id')
                          ->where('branch.deleted', '=', 0)
                          ->select('branch.*', 'users.name as username') // specify the columns you want to select
                          ->get();
    return view('branches.index', $data);
  }

  public function edit($id) {
    $bookingService = BranchModel::find($id);
    if ($bookingService) {
      $data['branch'] = $bookingService;
      $data['users'] = User::all();
      return view('branches.edit', $data);
    } else {
      return redirect()->back()->with('error', 'No service found with the specified id.');
    }
  }

  public function create() {
    $data['users'] = User::all();
    return view('branches.create', $data);
  }

  public function branch_create(Request $request) {
    $nameExists = BranchModel::where('name', $request->name)->exists();

    if (!$nameExists) {
      BranchModel::create($request->all());
      return response()->json(['success' => true, 'code' => 200]);
    } else {
      return response()->json(['success' => true, 'code' => 400]);
    }
  }

  public function branch_update(Request $request) {
    BranchModel::where('id', $request->id)->update($request->all());
    return response()->json(['success' => true, 'code' => 200]);
  }

  public function branch_delete(Request $request) {
    BranchModel::destroy($request->id);
    return response()->json(['success' => true, 'code' => 200]);
  }
}