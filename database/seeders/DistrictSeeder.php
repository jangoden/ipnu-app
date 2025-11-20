<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            'Banjaranyar', 'Banjarsari', 'Baregbeg', 'Ciamis', 'Cidolog', 'Cihaurbeuti',
            'Cijeungjing', 'Cikoneng', 'Cimaragas', 'Cipaku', 'Cisaga', 'Jatinagara',
            'Kawali', 'Lakbok', 'Lumbung', 'Pamarican', 'Panawangan', 'Panjalu',
            'Panumbangan', 'Purwadadi', 'Rajadesa', 'Rancah', 'Sadananya',
            'Sindangkasih', 'Sukadana', 'Sukamantri', 'Tambaksari'
        ];

        foreach ($districts as $district) {
            District::create(['name' => $district]);
        }
    }
}
