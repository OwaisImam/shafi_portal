<?php

namespace App\Repositories\BlogViewsRepository;

use App\Helper\Helper;
use App\Models\BlogViews;
use App\Repositories\BaseRepository;
use Jenssegers\Agent\Facades\Agent;
use Torann\GeoIP\Facades\GeoIP;

class BlogViewsRepository extends BaseRepository
{
    public function model(): string
    {
        return BlogViews::class;
    }

    public function addView($id)
    {
        $check = $this->model
                ->where('ip_address', Helper::getClientIpAddress())
                ->where('blog_id', $id)
                ->where('device', Agent::device() . ' - ' . Agent::browser())
                ->exists();

        if (!$check) {
            $geoip = GeoIP::getLocation(Helper::getClientIpAddress());
            $data = [
                  'blog_id' => $id,
                  'ip_address' => Helper::getClientIpAddress(),
                  'latitude' => $geoip['lat'],
                  'longitude' => $geoip['lon'],
                  'device' => Agent::device() . ' - ' . Agent::browser(),
            ];
            $this->create($data);
        }
    }
}
