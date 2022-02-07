<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel,WithHeadingRow
{
    private $password;

    public function __construct()
    {
        $this->password = Hash::make(123456);
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name' => $row['job_title'],
            'email' => $row['email'],
            'phone_number' => $row['phone_number'],
            'site' => $row['site'],
            'dept' => $row['department'],
            'supervisor_email' => $row['supervisor_email'],
            'password'  =>  $this->password,
        ]);
    }
}
