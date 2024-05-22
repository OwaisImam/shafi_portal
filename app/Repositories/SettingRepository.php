<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository extends BaseRepository
{
    public function model()
    {
        return Setting::class;
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

    public function updateSetting(array $types, array $params): void
    {
        foreach ($types as $key => $type) {

            if (isset($params[$type])) {
                if ($type == 'site_name') {
                    $this->overWriteEnvFile('APP_NAME', $params[$type]);
                }

                if ($type == 'timezone') {
                    $this->overWriteEnvFile('APP_TIMEZONE', $params[$type]);
                } else {
                    $lang = null;

                    if (gettype($type) == 'array') {
                        $lang = array_key_first($type);
                        $type = $type[$lang];
                        $business_settings = $this->model->where('type', $type)->first();
                    } else {
                        $business_settings = $this->model->where('type', $type)->first();
                    }

                    if ($business_settings != null) {
                        if (gettype($params[$type]) == 'array') {
                            $business_settings->value = json_encode($params[$type]);
                        } else {
                            $business_settings->value = $params[$type];
                        }
                        $business_settings->save();
                    } else {
                        $websiteSetting = (new Setting());
                        $websiteSetting->type = $type;

                        if (gettype($params[$type]) == 'array') {
                            $websiteSetting->value = json_encode($params[$type]);
                        } else {
                            $websiteSetting->value = $params[$type];
                        }

                        $websiteSetting->save();
                    }
                }
            }
        }
    }
}
