<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\ContactsModel;
use App\Model\User;
use App\Model\CorporatesModel;
use Illuminate\Http\Request;
use DB;

class CRMController extends Controller {
    public function __construct() {

    }

    public function index() {
        return view('crm.index');
    }

    public function all_accounts() {
        $data['customers'] = User::where('user_type', 'C')->get();
        return view('crm.all_accounts', $data);
    }

    public function corporate_accounts(Request $request)
    {
        $validPerPage = [10, 20, 50, 100];
        $data = $request->query();
        $searchkey =  isset($data['searchkey']) ? $data['searchkey'] : '';
        $perPage = isset($data['perPage']) && in_array($data['perPage'], $validPerPage) ? $data['perPage'] : 10;

        $corporateAccounts = CorporatesModel::query();

        if (!empty($searchkey)) {
            $corporateAccounts->where('name', 'LIKE', "%{$searchkey}%")
            ->orWhere('email', 'LIKE', "%{$searchkey}%");
        }

        $corporateAccounts->orderBy('updated_at', 'desc');

        $corporateAccounts = $corporateAccounts->paginate($perPage);

        return view('crm.corporate_accounts.index', compact('corporateAccounts'));
    }

    public function create_corporate_account(Request $request) {
        if($request->isMethod('get')){
            return view('crm.corporate_accounts.create');
        } else if($request->isMethod('post')) {

            // Check if a record with the same name already exists
            $existingService = CorporatesModel::firstWhere('name', $request->input('name'));
            if ($existingService) {
                // Return a response indicating that the name is already taken
                return response()->json(['success' => false, 'code' => 402]);
            }

            // Create a new BookingService
            $corporate = new CorporatesModel;

            // Set the properties
            $corporate->name = $request->input('name');
            $corporate->email = $request->input('email');
            $corporate->address = $request->input('address');
            $corporate->location = $request->input('location');
            $corporate->phone = $request->input('phone');

            if($request->hasFile('document')) {
                // Generate a new filename
                // Store the file in the 'uploads' disk, in the 'uploads' directory
                $uploads_dir = 'uploads/corporate_documents';
                $file = $request->file('document');
                $newFileName = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                $file->move($uploads_dir, $newFileName);
                $corporate->document = $newFileName;  // Store the path of the uploaded file
            }

            // Save the new BookingService
            $corporate->save();

            // Return a response
            return response()->json(['success' => true, 'code' => 200]);       
        }
    }

    public function edit_corporate_account(Request $request, $id) {
        if($request->isMethod('get')) {
            $data['account'] = CorporatesModel::find($id);
            if($data['account']) {
                return view('crm.corporate_accounts.edit', $data);
            } else {
                return redirect()->back()->with('error', 'No service found with the specified id.');
            }
        } else {
            
            // Check if a record with the same name already exists
            $existingService = CorporatesModel::firstWhere('name', $request->input('name'));
            if ($existingService) {
                // Return a response indicating that the name is already taken
                return response()->json(['success' => false, 'code' => 402]);
            }

            // Create a new BookingService
            $corporate = CorporatesModel::find($request->input('id'));

            // Set the properties
            $corporate->name = $request->input('name');
            $corporate->email = $request->input('email');
            $corporate->address = $request->input('address');
            $corporate->location = $request->input('location');
            $corporate->phone = $request->input('phone');
            $corporate->document = $request->input('document');

            if($request->hasFile('document')) {
                // Generate a new filename
                // Store the file in the 'uploads' disk, in the 'uploads' directory
                $uploads_dir = 'uploads/corporate_documents';
                $file = $request->file('document');
                $newFileName = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                $file->move($uploads_dir, $newFileName);
                $corporate->document = $newFileName;  // Store the path of the uploaded file
            }

            // Save the new BookingService
            $corporate->save();

            // Return a response
            return response()->json(['success' => true, 'code' => 200]);
        }
    }

    public function contacts(Request $request) {
        $data = $request->query();
        $account_id =  isset($data['account']) ? $data['account'] : 'all';
        $query = DB::table('contacts')
        ->leftJoin('corporates', 'contacts.account_id', '=', 'corporates.id');
        if($account_id !== 'all')
            $query->where('contacts.account_id', $account_id);
        $data['contacts'] = $query->orderBy('contacts.created_at', 'desc')->select("contacts.*", "corporates.name as u_name")->get();
        $data['accounts'] = CorporatesModel::orderBy('created_at', 'desc')->get();
        $data['active_account'] = $account_id;
        return view('crm.contacts.index', $data);
    }
}

?>