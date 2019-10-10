<?php

namespace App\Imports;

use App\Record;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Validator;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToCollection;
class RecordsImport implements ToModel, WithValidation,WithStartRow
{
    public $collection;

    public function startRow(): int
    {
        return 2;
    }

    public function customValidationAttributes()
    {
        return [
            '0' => 'First Name',
            '1' => 'Middle Name',
            '2'=>  'Last Name',
            '3' => 'Email',
            '4' => 'Phone #',
            '5' => 'Street',
            '6' => 'City',
            '7' => 'State',
            '8' => 'ZIP',
            '9' => 'Prior Street',
            '10' => 'Prior City',
            '11' => 'Prior State',
            '12' => 'Prior ZIP',
            '13' => 'Date of Birth',
            '14' => 'Current Employment',
            '15' => 'Policy Number',
            '16' => 'Line of Business',
            '17' => 'Claim Number',
            '18' => 'Date of Loss'
        ];
    }



    public function rules(): array
    {
        return [
            '0' => 'required|string|min:1|max:30',
            '2' => 'required|string|min:1|max:30',
            '3' => 'required|email',
//            '3' => 'required',
            '4' => 'required|min:1|max:40',
            '5' => 'max:40',
            '6' => 'required|string|min:1|max:30',
            '7' => 'required|string|min:1|max:30',
            '8' => 'max:20',
            '9' => 'required|string|min:1|max:20',
            '10' => 'required|string|min:1|max:30',
            '11' => 'required|string|min:1|max:30',
            '12' => 'max:20',
            '13' => 'required|string|min:1|max:30',
            '14' => 'max:200',
            '15' => 'required|min:1|max:150',
            '16' => 'max:100',
            '17' => 'required|min:1|max:150',
            '18' => 'required|min:1|max:150'
        ];
    }
    public function model(array $row)
    {
//        dd($row);
        return new Record([
            'first_name'     => $row[0],
            'middle_name'     => $row[1],
            'last_name'     => $row[2],
            'email'     => $row[3],
            'phone_no'     => $row[4],
            'current_street'     => $row[5],
            'current_city'     => $row[6],
            'current_state'     => $row[7],
            'current_zip'     => $row[8],
            'old_street'     => $row[9],
            'old_city'     => $row[10],
            'old_state'     => $row[11],
            'old_zip'     => $row[12],
            'dob'     => $row[13],
            'current_emp'     => $row[14],
            'policy_number'     => $row[15],
            'line_of_business'     => $row[16],
            'claim_number'     => $row[17],
            'loss_date'     => $row[18],
            'claim_desc'     => $row[19],
            'AddedBy'     => auth()->user()->id,
        ]);
    }
}
