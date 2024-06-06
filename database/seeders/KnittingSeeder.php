<?php

namespace Database\Seeders;

use App\Models\Knitting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KnittingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $knittings = [
            [
                "company_name" => "SKY FABRIC",
                "address" => "PLOT # 29, SECTOR-12-B, NORTH KARACHI.",
                "contact_person" => "MR. ARSALAN",
                "contact" => "923158558611"
            ],
            [
                "company_name" => "H-R KNITTING",
                "address" => "PLOT # 29-A, BLOCK -22, F.B AREA, NORTH KARACHI",
                "contact_person" => "MR.FAREED",
                "contact" => "923212699520"
            ],
            [
                "company_name" => "SULTANI HOSIERY",
                "address" =>"MALIK TEXTILE COMPOUND, PLOT # L-30, BLOCK-22, F.B AREA, NORTH KARACHI",
                "contact_person" => "MR. TAHIR",
                "contact" => "923412295891"
            ],
            [
                "company_name" => "M.M KNITTING",
                "address" =>"PLOT # 34, SECTOR-22-D, NORTH KARACHI.",
                "contact_person" => "MR. HAROON",
                "contact" => "923121294817"],
            [
                "company_name" => "HF- KNITTING",
                "address" =>"C.R-202, SECTOR- 16-B, GABOL TOWN, NORTH KARACHI.",
                "contact_person" => "MR. NADEEM",
                "contact" => "923085081818"
            ],
            [
                "company_name" => "TRIPLE H INDUSTRY",
                "address" =>"PLOT # C1-6-7-8, SECTOR-16-B, NORTH KARACHI.",
                "contact_person" => "MR.NASIR",
                "contact" => "923156699911"
            ],
            [
                "company_name" => "HUMZA KNITTING",
                "address" =>"PLOT # L-32 / D, BLOCK -22, F.B AREA, NORTH KARACHI.",
                "contact_person" => "MR.SHAHNAWAZ",
                "contact" => "923222869827"
            ]
        ];

        foreach($knittings as $knitting) {
            $exists = Knitting::where('company_name', $knitting['company_name'])->first();

            if(!$exists) {
                Knitting::create($knitting);
            }
        }
    }
}