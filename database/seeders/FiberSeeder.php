<?php

namespace Database\Seeders;

use App\Models\Fiber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FiberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fibers = [
            'CMBD CTN / MODAL 50/50',
            'CPV 50/35/15',
            'CTN',
            'CVC 55/45',
            'CVC 60/40',
            'CVC 75/25',
            'CVC 80/20',
            'CVC 90/10',
            'CVC 98/2',
            'CVC CMBD 60/40',
            'ELSTHN',
            'PC 52/48',
            'POLYESTER',
            'VISCOSE'
        ];

        foreach ($fibers as $fiber) {
            $exist = Fiber::where('name', $fiber)->first();
            if(!$exist) {
                Fiber::create(['name' => $fiber, 'status' => 1]);
            }
        }
    }
}