<?php

namespace App\Helper;

use App\Models\Client;
use App\Models\ClientTarget;
use App\Repositories\Page\PageRepository;
use App\Services\GoogleIndexingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Lib
{
    public static function updateAcheivedTargets()
    {
        $clients = Client::selectRaw('COUNT(*) as total_clients, created_by')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('created_by')
                ->get();

        foreach ($clients as $client) {
            $target = ClientTarget::where('user_id', $client->created_by)
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->first();

            $updated = $target?->update([
                'acheived' => $client->total_clients,
            ]);

            if ($updated) {
                Log::info('acheived updated of user: ' . $client->created_by);
            }
        }
    }

    public static function updatePageInGoogleIndexing()
    {
        $page = new PageRepository();

        $pages = $page->all();

        foreach ($pages as $page) {
            $googleIndexingService = new GoogleIndexingService();
            $url = env('APP_URL');

            if ($page->slug != null) {
                if ($page->page_type == 'service') {
                    $url .= 'services/';
                }
                $url .= $page->slug;
            }

            $googleIndexingService->updateUrl($url);
        }
    }
}
