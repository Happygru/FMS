<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\CorporatesModel;
use Illuminate\Http\Request;

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

        $corporateAccounts = $corporateAccounts->paginate($perPage);

        return view('crm.corporate_accounts.index', compact('corporateAccounts'));
    }
}

?>