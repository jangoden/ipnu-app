<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class AlumniMembersExport implements FromCollection, WithHeadings
{
    protected $members;

    public function __construct(Collection $members)
    {
        $this->members = $members;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->members->map(function ($member) {
            return [
                'full_name' => $member->full_name,
                'address' => $member->address,
                'hobby' => $member->hobby,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Address',
            'Hobby',
        ];
    }
}
