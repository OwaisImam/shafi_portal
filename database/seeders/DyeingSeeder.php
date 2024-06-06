<?php

namespace Database\Seeders;

use App\Models\Dyeing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DyeingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dyeings = [
            [
                "company_name" => "KNIT WEAR DYEING",
                "address" => "   PLOT # 377-378, SHAH BAIG, BLOCK-22, F.B, AREA, GABOL TOWN, NORTH KARACHI",
                "contact_person" => "MR. FAISAL",
                "contact" => "92301273665"
            ],
            [
                "company_name" => "AL- AMNA DYEING",
                "address" => "PLOT # DP- 70,SECTOR-12-C, NORTH KARACHI.",
                "contact_person" => "MR. ADEEL",
                "contact" => "923128548584"
            ],
            [
                "company_name" => "R.B.S",
                "address" =>"PLOT # 15/5, SECTOR-12-C,NORTH KARACHI.",
                "contact_person" => "MR.SHAKOOR ",
                "contact" => "923219262877"
            ],
            [
                "company_name" => "GLOBE DYEING",
                "address" =>"PLOT # L-26 /B & C, BLOCK -22, F.B AREA, NORTH KARACHI.",
                "contact_person" => "MR. IMRAN",
                "contact" => "923121126659"
            ],
        ];

        foreach($dyeings as $dyeing) {
            $exists = Dyeing::where('company_name', $dyeing['company_name'])->first();

            if(!$exists) {
                Dyeing::create($dyeing);
            }
        }
    }
}
