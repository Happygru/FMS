<?php

namespace App\Imports;

use App\Model\ExpCats;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;

class ExpenseCategoriesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $expense)
    {
        if ($expense['category_name'] != null) {
            ExpCats::create([
                "name" => $expense['category_name'],
                "user_id" => Auth::id(),
                "type" => "u",
            ]);
        }
    }
}
