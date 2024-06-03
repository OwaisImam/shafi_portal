<?php

namespace Database\Seeders;

use App\Constants\DefaultValues;
use App\Models\Process;
use Illuminate\Database\Seeder;

class ProcessSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (DefaultValues::PROCESSES as $process) {
            $exist = Process::where('name', $process)->first();

            if (!$exist) {
                Process::create([
                    'name' => $process,
                    'status' => 1,
                    'is_default' => 1,
                ]);
            }
        }
    }
}
