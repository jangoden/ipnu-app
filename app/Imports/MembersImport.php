<?php

namespace App\Imports;

use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MembersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Member([
            'nik' => $row['nik'],
            'nia' => $row['nia'],
            'username' => $row['username'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
            'full_name' => $row['full_name'],
            'birth_place' => $row['birth_place'],
            'birth_date' => $row['birth_date'],
            'address' => $row['address'],
            'district_id' => $row['district_id'],
            'village_id' => $row['village_id'],
            'phone_number' => $row['phone_number'],
            'hobby' => $row['hobby'],
            'status' => $row['status'] ?? 'active',
            'grade' => $row['grade'] ?? 'anggota',
        ]);
    }

    public function rules(): array
    {
        return [
            'nik' => 'required|unique:members,nik',
            'email' => 'required|email|unique:members,email',
            'username' => 'required|unique:members,username',
            'full_name' => 'required',
            'password' => 'required',
            // Add other rules as necessary
        ];
    }
}
