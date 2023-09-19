<?php

namespace App\Imports;

use App\Model\IncCats;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;

class IncomeCategoriesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $income)
    {
        if ($income['category_name'] != null || $income['category_name'] != " ") {
            IncCats::create([
                "name" => $income['category_name'],
                "user_id" => Auth::id(),
                "type" => "u",
            ]);
        }
    }
}
