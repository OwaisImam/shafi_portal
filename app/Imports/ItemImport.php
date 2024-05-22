<?php

namespace App\Imports;

use App\Models\Item;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $item_count = Item::where('name', $row['name'])->count();

            if ($item_count == 0) {
                Item::create([
                    'name' => ucwords(strtolower($row['name'])),
                    'status' => $row['status'],
                ]);
            }
        }
    }
}
