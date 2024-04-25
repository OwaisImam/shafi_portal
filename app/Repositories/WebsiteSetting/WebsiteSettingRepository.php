<?php

namespace App\Repositories\WebsiteSetting;

use App\Models\WebsiteSetting;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IWebsiteSettingRepository;

class WebsiteSettingRepository extends BaseRepository implements IWebsiteSettingRepository
{
    public function model(): string
    {
        return WebsiteSetting::class;
    }

    public function getSettingByKey($key): WebsiteSetting
    {
        return $this->model->where('type', $key)->first();
    }

    public function selectByColumns(array $columns)
    {
        return $this->all($columns);
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
                        $websiteSetting = (new WebsiteSetting);
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

    public function overWriteEnvFile($type, $val)
    {
        if (env('DEMO_MODE') != 'On') {
            $path = base_path('.env');

            if (file_exists($path)) {
                $val = '"' . trim($val) . '"';

                if (is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0) {
                    file_put_contents($path, str_replace(
                        $type . '="' . env($type) . '"',
                        $type . '=' . $val,
                        file_get_contents($path)
                    ));
                } else {
                    file_put_contents($path, file_get_contents($path) . "\r\n" . $type . '=' . $val);
                }
            }
        }
    }
}
