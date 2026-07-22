<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    public function __invoke()
    {
        // Auto-fetch news fallback (checks if fetched in last 2 hours)
        if (!Cache::has('news_fetched_recently')) {
            try {
                Artisan::call('news:fetch');
                Cache::put('news_fetched_recently', true, now()->addHours(2));
            } catch (\Throwable $e) {
                // Silently continue if something goes wrong (e.g., offline)
            }
        }

        $latestNews = NewsItem::query()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        return view('welcome', compact('latestNews'));
    }
}
