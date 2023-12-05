<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\PotentialStudent;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportPotentialStudent implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0] !== null && $row[0] !== 'Nama lengkap'){
            return new PotentialStudent([
                'name' => $row[0],
                'email' => $row[8],
                'gender' => $row[3],
                'birth_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4])),
                'education' => $row[6],
                'city' => $row[2],
                'address' => $row[1],
                'phone_number' => $row[7],
            ]);
        }
    }
}
