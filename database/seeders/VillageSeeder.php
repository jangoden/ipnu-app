<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Village;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('villages')->truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            'Banjaranyar' => ['Banjaranyar', 'Cigayam', 'Cikaso', 'Cikupa', 'Kalijaya', 'Karyamukti', 'Langkapsari', 'Pasawahan', 'Sindangrasa', 'Tanjungsari'],
            'Banjarsari' => ['Banjarsari', 'Cibadak', 'Cicapar', 'Ciherang', 'Ciulu', 'Kawasen', 'Purwasari', 'Ratawangi', 'Sindangasih', 'Sindanghayu', 'Sindangsari', 'Sukasari'],
            'Baregbeg' => ['Baregbeg', 'Jelat', 'Karang Ampel', 'Mekarjaya', 'Petir Hilir', 'Pusakanagara', 'Saguling', 'Sukamaju', 'Sukamulya'],
            'Ciamis' => ['Cisadap', 'Imbanagara Raya', 'Imbanagara', 'Panyingkiran', 'Pawindan'],
            'Cidolog' => ['Cidolog', 'Ciparay', 'Hegarmanah', 'Janggala', 'Jelegong', 'Sukasari'],
            'Cihaurbeuti' => ['Cihaurbeuti', 'Cijulang', 'Padamulya', 'Pamokolan', 'Pasirtamiang', 'Sukahaji', 'Sukahurip', 'Sukamaju'],
            'Cijeungjing' => ['Bojongmengger', 'Ciharalang', 'Cijeungjing', 'Dewasari', 'Handapherang', 'Karanganyar', 'Kertabumi', 'Kertaharja', 'Pamalayan', 'Utama', 'Waringin'],
            'Cikoneng' => ['Cikoneng', 'Cimari', 'Darmacaang', 'Jagabaya', 'Kujang', 'Margaluyu', 'Nasol', 'Panaragan', 'Sindangrasa', 'Sukajadi', 'Sukamulya'],
            'Cimaragas' => ['Beber', 'Bojongmalang', 'Cimaragas', 'Jayaraksa', 'Raksabaya', 'Sadarwangi'],
            'Cipaku' => ['Bangbayang', 'Buniseuri', 'Ciakar', 'Cieurih', 'Cipaku', 'Gelarmulya', 'Mekarsari', 'Muktisari', 'Pusakasari', 'Selacai', 'Sirnajaya'],
            'Cisaga' => ['Bangunharja', 'Cisaga', 'Danasari', 'Karyamulya', 'Mekarmukti', 'Sidamulya', 'Sukahurip', 'Tanjungjaya', 'Wangunjaya'],
            'Jatinagara' => ['Bayasari', 'Jatinagara', 'Mulyasari', 'Sukanagara', 'Winangun'],
            'Kawali' => ['Citeureup', 'Karangpawitan', 'Kawali', 'Kawalimukti', 'Linggapura', 'Margamulya', 'Purwasari', 'Selasari', 'Sindangsari', 'Winduraja'],
            'Lakbok' => ['Baregbeg', 'Cintajaya', 'Kalapasawit', 'Lakbok', 'Puloerang', 'Sidaharja', 'Sindangangin', 'Sukanagara', 'Tambakreja'],
            'Lumbung' => ['Awiluar', 'Cikupa', 'Darmaraja', 'Lumbung', 'Lumbungsari', 'Rawa'],
            'Pamarican' => ['Bangunsari', 'Bantarsari', 'Kertahayu', 'Kertamukti', 'Margajaya', 'Neglasari', 'Pamarican', 'Sidamulih', 'Sukahurip', 'Sukajadi'],
            'Panawangan' => ['Bangunjaya', 'Cinyasag', 'Darmaraja', 'Indragiri', 'Jagabaya', 'Karangpaningal', 'Kertajaya', 'Nagarajaya', 'Nagarapageuh', 'Panawangan', 'Sadapaingan'],
            'Panjalu' => ['Bahara', 'Ciomas', 'Haurkuning', 'Kertamandala', 'Panjalu', 'Sindangherang', 'Tanjungjaya', 'Terung'],
            'Panumbangan' => ['Banjarangsana', 'Buanamekar', 'Jayagiri', 'Kertaraharja', 'Medanglayang', 'Panumbangan', 'Payungagung', 'Sindangmukti', 'Sindangwangi', 'Sukakerta', 'Sukamaju', 'Tanjungmulya'],
            'Purwadadi' => ['Bantardawa', 'Karangpaningal', 'Kutawaringin', 'Padamulya', 'Purwadadi', 'Purwadadi Utara', 'Sidarahayu', 'Sukajaya', 'Surabaya'],
            'Rajadesa' => ['Andapraja', 'Purwaraja', 'Rajadesa', 'Sirnabaya', 'Sukaharja', 'Sukajaya', 'Tanjungsari', 'Tigaherang'],
            'Rancah' => ['Bojonggedang', 'Cileungsir', 'Cisontrol', 'Dadiharja', 'Geresik', 'Jangraga', 'Karangpari', 'Kaso', 'Rancah', 'Situmandala'],
            'Sadananya' => ['Bendasari', 'Gunungsari', 'Mangkubumi', 'Sadananya', 'Sukajadi', 'Tanjungsari'],
            'Sindangkasih' => ['Budiasih', 'Budiharja', 'Sindangkasih', 'Sukamanah', 'Sukaraja', 'Sukaresik', 'Wanasigra'],
            'Sukadana' => ['Bunter', 'Ciparigi', 'Margaharja', 'Mekarwangi', 'Padakembang', 'Sakadana', 'Sukadana'],
            'Sukamantri' => ['Cibeureum', 'Cieurih', 'Mekarwangi', 'Sindanglaya', 'Sukamantri', 'Tenggerraharja'],
            'Tambaksari' => ['Kadupandak', 'Karangmulyan', 'Kaso', 'Mekarsari', 'Sukasari', 'Tambaksari'],
        ];

        foreach ($data as $districtName => $villages) {
            $district = District::where('name', $districtName)->first();

            if ($district) {
                foreach ($villages as $villageName) {
                    Village::create([
                        'district_id' => $district->id,
                        'name' => $villageName,
                    ]);
                }
            }
        }
    }
}

