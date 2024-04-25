<?php

namespace App\Repositories\Settings;

use App\Models\Quotation;
use App\Repositories\BaseRepository;

class SettingsRepository extends BaseRepository
{
    public function model(): string
    {
        return Quotation::class;
    }

    public function overWriteEnvFile($type, $val)
    {

        $path = base_path('.env');

        if (file_exists($path)) {
            // Surround the value with quotes if it's not empty
            if (trim($val) !== '') {
                $val = '"' . trim($val) . '"';
            } else {
                $val = null;
            }

            $envContents = file_get_contents($path);
            $pattern = '/^' . preg_quote($type, '/') . '=.*/m';

            // Check if the variable exists in the .env file
            if (preg_match($pattern, $envContents)) {
                // Replace the existing value with the new one
                $envContents = preg_replace($pattern, $type . '=' . $val, $envContents);
            } else {
                // Append the new variable to the end of the file
                $envContents .= "\n" . $type . '=' . $val;
            }

            // Write the updated contents back to the .env file
            file_put_contents($path, $envContents);
        }

    }
}
