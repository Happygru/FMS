<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\ContactsModel;
use App\Model\DocumentsModel;
use App\Model\User;
use App\Model\Log;
use Illuminate\Http\Request;
use DB;

class CRMController extends Controller {
    public function __construct() {

    }

    public function index(Request $request) {
        Log::activity($request, 'View CRM page');
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

        $corporateAccounts = User::where('user_type', "C")->where('customer_type', "C");

        if (!empty($searchkey)) {
            $corporateAccounts->where('name', 'LIKE', "%{$searchkey}%")
            ->orWhere('email', 'LIKE', "%{$searchkey}%");
        }

        $corporateAccounts->orderBy('updated_at', 'desc');

        $corporateAccounts = $corporateAccounts->paginate($perPage);
        Log::activity($request, 'View CRM / Corporate Accounts page');
        return view('crm.corporate_accounts.index', compact('corporateAccounts'));
    }

    public function create_corporate_account(Request $request) {
        if($request->isMethod('get')){
            Log::activity($request, 'View Create Corporate Account page');
            return view('crm.corporate_accounts.create');
        } else if($request->isMethod('post')) {
            $existingService = User::firstWhere('email', $request->input('email'));
            if ($existingService) {
                // Return a response indicating that the name is already taken
                return response()->json(['success' => false, 'code' => 402]);
            }
    
    
            $corporate = new User;
    
            if($request->hasFile('avatar')) {
                // Generate a new filename
                // Store the file in the 'uploads' disk, in the 'uploads' directory
                $uploads_dir = 'uploads/avatars';
                $file = $request->file('avatar');
                $newFileName = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                $file->move($uploads_dir, $newFileName);
                $corporate->avatar = $newFileName;  // Store the path of the uploaded file
            }
    
            // Set the properties
            $corporate->name = $request->input('name');
            $corporate->email = $request->input('email');
            $corporate->gender = $request->input('gender');
            $corporate->phone = $request->input('phone');
            $corporate->addr = $request->input('address');
            $corporate->location = $request->input('location');
            $corporate->customer_type = $request->input('customer_type');
            $corporate->user_type = 'C';
            Log::activity($request, 'Create a new corporate account');
            // Save the new BookingService
            $corporate->save();
    
            return response()->json(['success' => true, 'code' => '200']); 
        }
    }

    public function edit_corporate_account(Request $request, $id) {
        if($request->isMethod('get')) {
            $data['data'] = User::where('id', $id)->first();
            if($data['data']) {
                Log::activity($request, 'View Edit Corporate Account page');
                return view('crm.corporate_accounts.edit', $data);
            } else {
                return redirect()->back()->with('error', 'No service found with the specified id.');
            }
        } else {
            
            $corporate = User::find($request->id);
            if (!$corporate) {
                // Return a response indicating that the name is already taken
                return response()->json(['success' => false, 'code' => 402]);
            }
    
            // Set the properties
            $corporate->name = $request->input('name');
            $corporate->email = $request->input('email');
            $corporate->gender = $request->input('gender');
            $corporate->phone = $request->input('phone');
            $corporate->addr = $request->input('address');
            $corporate->location = $request->input('location');
            $corporate->customer_type = $request->input('customer_type');
            // Save the new BookingService
            $corporate->save();

            Log::activity($request, 'Update a corporate cccount');
    
            return response()->json(['success' => true, 'code' => 200]);
        }
    }

    public function contacts(Request $request) {
        $data = $request->query();
        $account_id =  isset($data['account']) ? $data['account'] : 'all';
        $query = DB::table('contacts')->leftJoin('users', 'contacts.account_id', '=', 'users.id');
        if($account_id !== 'all')
            $query->where('contacts.account_id', $account_id);
        $data['contacts'] = $query->orderBy('contacts.created_at', 'desc')->select("contacts.*", "users.name as u_name")->get();
        $data['accounts'] = User::where('user_type', 'C')->where('customer_type', 'C')->orderBy('created_at', 'desc')->get();
        $data['active_account'] = $account_id;
        Log::activity($request, 'View contacts page');
        return view('crm.contacts.index', $data);
    }

    public function create_contact(Request $request) {
        if($request->isMethod('get')) {
            Log::activity($request, 'View Create contact page');
            $data['accounts'] = User::where('user_type', 'C')->where('customer_type', 'C')->orderBy('created_at', 'desc')->get();
            return view('crm.contacts.create', $data);
        } else {
            $contact = ContactsModel::where('name', $request->name)->first();
    
            if ($contact) {
                return response()->json(['success' => false, 'message' => 'Contact with this name already exists']);
            }
        
            $newContact = new ContactsModel;
            $newContact->account_id = $request->account_id;
            $newContact->name = $request->name;
            $newContact->email = $request->email;
            $newContact->phone = $request->phone;
            $newContact->job = $request->job;

            $newContact->save();
            Log::activity($request, 'Create new contact');
            if ($newContact) {
                return response()->json(['success' => true, 'message' => 'Contact created successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to create contact']);
            }
        }
    }

    public function edit_contact(Request $request, $id = 0) {
        if($request->isMethod('get')) {
            Log::activity($request, 'View Edit contact page');
            $data['accounts'] = User::where('user_type', 'C')->where('customer_type', 'C')->orderBy('created_at', 'desc')->get();
            $data['contact'] = ContactsModel::find($id);
            return view('crm.contacts.edit', $data);            
        } else {
            $contact = ContactsModel::find($request->id);
            $contact->account_id = $request->account_id;
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->phone = $request->phone;
            $contact->job = $request->job;
            $contact->save();
            Log::activity($request, 'Edit contact');
            return response()->json(['success' => true]);
        }
    }

    public function documents(Request $request)
    {
        $validPerPage = [10, 20, 50, 100];
        $data = $request->query();
        $searchkey =  isset($data['searchkey']) ? $data['searchkey'] : '';
        $perPage = isset($data['perPage']) && in_array($data['perPage'], $validPerPage) ? $data['perPage'] : 10;

        $documents = DB::table('documents as d')
                                ->leftJoin('users as c', 'd.corporate_id', '=', 'c.id')
                                ->select("d.*", "c.name as c_name");

        if (!empty($searchkey)) {
            $documents->where('d.name', 'LIKE', "%{$searchkey}%")->orWhere('c.name', 'LIKE', "%{$searchkey}%")
            ->orWhere('d.description', 'LIKE', "%{$searchkey}%");
        }

        $documents->orderBy('updated_at', 'desc');

        $documents = $documents->paginate($perPage);
        Log::activity($request, 'View documents page');
        return view('crm.documents.index', compact('documents'));
    }

    public function create_document(Request $request) {
        if($request->isMethod('get')){
            Log::activity($request, 'View create document page');
            $data['corporates'] = User::where('user_type', 'C')->where('customer_type', 'C')->orderBy('created_at', 'desc')->get();
            return view('crm.documents.create', $data);
        } else if($request->isMethod('post')) {

            // Check if a record with the same name already exists
            $existingService = DocumentsModel::firstWhere('name', $request->input('name'));
            if ($existingService) {
                // Return a response indicating that the name is already taken
                return response()->json(['success' => false, 'code' => 402]);
            }

            $corporate = new DocumentsModel;

            // Set the properties
            $corporate->name = $request->input('name');
            $corporate->description = $request->input('description');
            $corporate->corporate_id = $request->input('corporate_id');

            if($request->hasFile('document')) {
                // Generate a new filename
                // Store the file in the 'uploads' disk, in the 'uploads' directory
                $uploads_dir = 'uploads/corporate_documents';
                $file = $request->file('document');
                $newFileName = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                $file->move($uploads_dir, $newFileName);
                $corporate->attach = $newFileName;  // Store the path of the uploaded file
            }

            // Save the new BookingService
            $corporate->save();
            Log::activity($request, 'Create new document');
            // Return a response
            return response()->json(['success' => true, 'code' => 200]);       
        }
    }

    public function edit_document(Request $request, $id) {
        if($request->isMethod('get')) {
            Log::activity($request, 'View Edit Document Page');
            $data['document'] = DocumentsModel::find($id);
            $data['corporates'] = User::where('user_type', 'C')->where('customer_type', 'C')->orderBy('created_at', 'desc')->get();
            if($data['document']) {
                return view('crm.documents.edit', $data);
            } else {
                return redirect()->back()->with('error', 'No service found with the specified id.');
            }
        } else {
            
            // Check if a record with the same name already exists
            $existingService = DocumentsModel::firstWhere('name', $request->input('name'));
            if ($existingService) {
                // Return a response indicating that the name is already taken
                return response()->json(['success' => false, 'code' => 402]);
            }

            // Create a new BookingService
            $corporate = DocumentsModel::find($request->input('id'));

            // Set the properties
            $corporate->name = $request->input('name');
            $corporate->description = $request->input('description');
            $corporate->corporate_id = $request->input('corporate_id');

            if($request->hasFile('document')) {
                // Generate a new filename
                // Store the file in the 'uploads' disk, in the 'uploads' directory
                $uploads_dir = 'uploads/corporate_documents';
                $file = $request->file('document');
                $newFileName = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                $file->move($uploads_dir, $newFileName);
                $corporate->attach = $newFileName;  // Store the path of the uploaded file
            }

            // Save the new BookingService
            $corporate->save();
            Log::activity($request, 'Edit document');
            // Return a response
            return response()->json(['success' => true, 'code' => 200]);
        }
    }

    public function leads(Request $request) {
        $validPerPage = [10, 20, 50, 100];
        $data = $request->query();
        $searchkey =  isset($data['searchkey']) ? $data['searchkey'] : '';
        $perPage = isset($data['perPage']) && in_array($data['perPage'], $validPerPage) ? $data['perPage'] : 10;

        $leads = 

        if (!empty($searchkey)) {
            $documents->where('d.name', 'LIKE', "%{$searchkey}%")->orWhere('c.name', 'LIKE', "%{$searchkey}%")
            ->orWhere('d.description', 'LIKE', "%{$searchkey}%");
        }

        $documents->orderBy('updated_at', 'desc');

        $documents = $documents->paginate($perPage);
        Log::activity($request, 'View Lead Management Page');
        return view('crm.leads.index');
    }

    public function delete_contact(Request $request) {
        $contact = ContactsModel::find($request->id);
        $contact->delete();
        Log::activity($request, 'Delete contact');
        return response()->json(['success' => true]);
    }

    public function delete_corporate(Request $request) {
        $contact = User::find($request->id);
        $contact->delete();
        Log::activity($request, 'Delete corporate');
        return response()->json(['success' => true]);
    }

    public function delete_document(Request $request) {
        $contact = DocumentsModel::find($request->id);
        $contact->delete();
        Log::activity($request, 'Delete document');
        return response()->json(['success' => true]);
    }
}

?>