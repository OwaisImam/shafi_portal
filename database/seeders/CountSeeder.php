<?php

namespace Database\Seeders;

use App\Models\Count;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $counts = [
            '08/1',
            '10/1',
            '10/1 AC',
            '10/1 RING RG',
            '100/48 IM',
            '150/48 Hi IM BLK',
            '16/1',
            '16/1 RING RG',
            '18/1 CMBD',
            '20/1',
            '20/1 BCI',
            '20/1 CD CF',
            '20/1 CF',
            '20/1 CHAIN ECRU',
            '20/1 CMBD',
            '20/1 P-12',
            '20/1 R-1',
            '20/1 R-9',
            '20/1 SM 603 BLK',
            '24/1',
            '24/1 COMBED',
            '26/1',
            '26/1 CD CF',
            '26/1 CMBD',
            '26/1 P-12',
            '26/1 R-1',
            '26/1 R-9',
            '30 Dnr',
            '30/1',
            '30/1 BCI',
            '30/1 CD CF',
            '30/1 CF',
            '30/1 CHAIN ECRU',
            '30/1 CMBD',
            '30/1 P-12',
            '30/1 R-1',
            '30/1 R-9',
            '30/1 SM 603 BLK',
            '30/1 TRIBLEND',
            '300/96 ZERO',
            '36/1 CMBD CF',
            '50/36 ZERO',
            '75/24 Zero',
            '75/24 ZERO BLK',
            '75/24 Zero RG',
            'FLEECE',
            'LOOP TERRY',
            'MESH',
            'POLAR FLEECE',
        ];

        foreach ($counts as $count) {
            $exist = Count::where('name', $count)->first();
            if(!$exist) {
                Count::create(['name' => $count, 'status' => 1]);
            }
        }
    }
}
