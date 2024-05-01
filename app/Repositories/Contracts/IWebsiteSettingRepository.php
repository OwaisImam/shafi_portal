<?php

namespace App\Repositories\Contracts;

use App\Models\WebsiteSetting;
use App\Repositories\RepositoryContract;
use Illuminate\Database\Eloquent\Model;

interface IWebsiteSettingRepository extends RepositoryContract
{
    public function create(array $data): Model|WebsiteSetting;

    public function updateSetting(array $types, array $params);
}
