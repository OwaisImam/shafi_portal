<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $suppliers = [
            ['code' => '016', 'name' => 'ABID ENTERPRISES', 'contact_person' => 'MR. AZHAR', 'contact_number' => '03122002516', 'category_id' => 1, 'status' => '1'],
            ['code' => '008', 'name' => 'AL-REHMAN PACKAGES', 'contact_person' => 'MR. SUFYAN', 'contact_number' => '03002446800', 'category_id' => 1, 'status' => '1'],
            ['code' => '012', 'name' => 'ASMA ENTERPRISES', 'contact_person' => 'MR. RASHEED', 'contact_number' => '03042483393', 'category_id' => 1, 'status' => '1'],
            ['code' => '014', 'name' => 'ATS PACK', 'contact_person' => 'MR. RIZWAN', 'contact_number' => '03122360222', 'category_id' => 1, 'status' => '1'],
            ['code' => '023', 'name' => 'ES ENTERPRISES', 'contact_person' => 'MR. IMRAN', 'contact_number' => '03100300426', 'category_id' => 1, 'status' => '1'],
            ['code' => '018', 'name' => 'HASSAN PACKAGES', 'contact_person' => 'MR. MUDASSIR', 'contact_number' => '03323486712', 'category_id' => 1, 'status' => '1'],
            ['code' => '021', 'name' => 'JAVAID BROTHERS', 'contact_person' => 'MR. WASIF', 'contact_number' => '03008284714', 'category_id' => 1, 'status' => '1'],
            ['code' => '009', 'name' => 'KHWAJA PACKAGES', 'contact_person' => 'MR. AZIZ', 'contact_number' => '03333788851', 'category_id' => 1, 'status' => '1'],
            ['code' => '025', 'name' => 'LOCAL', 'contact_person' => '-', 'contact_number' => '-', 'category_id' => 2, 'status' => '1'],
            ['code' => '019', 'name' => 'MAINETTI', 'contact_person' => 'MR. AYAZ', 'contact_number' => '03018253110', 'category_id' => 1, 'status' => '1'],
            ['code' => '004', 'name' => 'MD ZAHID', 'contact_person' => 'MR. ZAHID', 'contact_number' => '03009207304', 'category_id' => 1, 'status' => '1'],
            ['code' => '024', 'name' => 'MD. JUNAID', 'contact_person' => 'MR. JUNAID', 'contact_number' => '03228244423', 'category_id' => 1, 'status' => '1'],
            ['code' => '022', 'name' => 'MD. SHABBIR', 'contact_person' => 'MR. SHABBIR', 'contact_number' => '03009655163', 'category_id' => 1, 'status' => '1'],
            ['code' => '017', 'name' => 'MOBINE ENTERPRISES', 'contact_person' => 'MR. TALHA', 'contact_number' => '03343909080', 'category_id' => 1, 'status' => '1'],
            ['code' => '010', 'name' => 'ROYAL TEXTILE', 'contact_person' => 'MR. SALEEM', 'contact_number' => '03222061927', 'category_id' => 1, 'status' => '1'],
            ['code' => '007', 'name' => 'S.K TRADERS', 'contact_person' => 'MR. SHAHZAIB', 'contact_number' => '03323581158', 'category_id' => 1, 'status' => '1'],
            ['code' => '015', 'name' => 'SHAHEEN CONTAINER', 'contact_person' => 'MR. FEROZ', 'contact_number' => '03155642886', 'category_id' => 1, 'status' => '1'],
            ['code' => '005', 'name' => 'SHAHZAR & BROTHERS', 'contact_person' => 'MR. FARHAN', 'contact_number' => '03163482803', 'category_id' => 1, 'status' => '1'],
            ['code' => '006', 'name' => 'SS ENTERPRISES', 'contact_person' => 'MR. SALMAN', 'contact_number' => '03009224551', 'category_id' => 1, 'status' => '1'],
            ['code' => '003', 'name' => 'TAJ TRADERS', 'contact_person' => 'MR. TAJ', 'contact_number' => '03328248878', 'category_id' => 1, 'status' => '1'],
            ['code' => '013', 'name' => 'TARIQ LACE', 'contact_person' => 'MR. SALEEM', 'contact_number' => '03212435794', 'category_id' => 1, 'status' => '1'],
            ['code' => '011', 'name' => 'TEXTILE THREADS', 'contact_person' => 'MR. KASHIF', 'contact_number' => '03032101718', 'category_id' => 1, 'status' => '1'],
            ['code' => '002', 'name' => 'UMAIR BROTHERS', 'contact_person' => 'MR. ZUBAIR', 'contact_number' => '03002714379', 'category_id' => 1, 'status' => '1'],
            ['code' => '020', 'name' => 'YKK', 'contact_person' => 'MS. SHANZA', 'contact_number' => '03101033004', 'category_id' => 1, 'status' => '1'],
            ['code' => '001', 'name' => 'ZUBAIR YOUSUF', 'contact_person' => 'MR. ZUBAIR', 'contact_number' => '03219211639', 'category_id' => 1, 'status' => '1'],
        ];

        foreach($suppliers as $supplier) {
            $exist = Supplier::where('name', $supplier['name'])->first();
            if(!$exist) {
                Supplier::create($supplier);
            }
        }
    }
}