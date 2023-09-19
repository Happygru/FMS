<?php

namespace App\Imports;

use App\Model\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $customer)
    {
        if ($customer['email'] != null) {
            $id = User::create([
                "name" => $customer['first_name'] . " " . $customer['last_name'],
                "email" => $customer['email'],
                "password" => bcrypt($customer['password']),
                "user_type" => "C",
                "api_token" => str_random(60),
            ])->id;
            $user = User::find($id);
            $user->first_name = $customer['first_name'];
            $user->last_name = $customer['last_name'];
            $user->address = $customer['address'];
            $user->mobno = $customer['phone'];
            if ($customer['gender'] == "female") {
                $user->gender = 0;
            } else {
                $user->gender = 1;
            }
            $user->save();
            $user->givePermissionTo(['Bookings add','Bookings edit','Bookings list','Bookings delete']);
        }
    }
}
