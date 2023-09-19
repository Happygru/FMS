<?php

namespace App\Imports;

use App\Model\Vendor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VendorImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $vendor)
    {
        if ($vendor['name'] != null) {
            Vendor::create([
                'name' => $vendor['name'],
                'phone' => $vendor['phone'],
                'email' => $vendor['email'],
                'type' => $vendor['type'],
                'website' => $vendor['website'],
                'address1' => $vendor['address1'],
                'address2' => $vendor['address2'],
                'city' => $vendor['city'],
                'province' => $vendor['stateprovince'],
                'postal_code' => $vendor['postal_code'],
                'country' => $vendor['country'],
                'note' => $vendor['note'],
            ]);
        }
    }
}
