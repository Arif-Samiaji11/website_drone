<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\NewsItem;
use Carbon\Carbon;

class FetchNewsRss extends Command
{
    protected $signature = 'news:fetch';
    protected $description = 'Fetch national drone-related news in Indonesia from Google News RSS feed';

    public function handle()
    {
        $feeds = [
            'https://news.google.com/rss/search?q=drone+indonesia+OR+uav+indonesia&hl=id&gl=ID&ceid=ID:id',
        ];

        $insertedOrUpdated = 0;

        foreach ($feeds as $feed) {
            try {
                $response = Http::timeout(15)->get($feed);
                if (!$response->ok()) continue;

                $xml = @simplexml_load_string($response->body());
                if (!$xml || !isset($xml->channel->item)) continue;

                foreach ($xml->channel->item as $item) {
                    $url = (string) ($item->link ?? '');
                    $originalTitle = trim((string) ($item->title ?? ''));
                    $sourceName = trim((string) ($item->source ?? 'Google News'));

                    if (!$url || !$originalTitle) continue;

                    // Clean the title by removing trailing " - Source Name"
                    $title = $originalTitle;
                    if ($sourceName) {
                        $suffix = ' - ' . $sourceName;
                        if (str_ends_with($title, $suffix)) {
                            $title = substr($title, 0, -strlen($suffix));
                        } else {
                            $pos = strrpos($title, ' - ');
                            if ($pos !== false && $pos > strlen($title) - 40) {
                                $title = substr($title, 0, $pos);
                            }
                        }
                    }
                    $title = trim($title);

                    // Parse publication date
                    $publishedAt = null;
                    try {
                        $publishedAt = Carbon::parse((string) ($item->pubDate ?? null));
                    } catch (\Throwable $e) {
                        $publishedAt = now();
                    }

                    // Excerpt is not provided in detail by Google News, so we use a friendly fallback
                    $excerptFinal = "Baca detail selengkapnya di sumber berita " . $sourceName . ".";

                    // Determine slug
                    $baseSlug = Str::slug($title);
                    if (!$baseSlug) $baseSlug = 'berita-drone';

                    $existing = NewsItem::where('url', $url)->first();
                    $slugFinal = $existing?->slug ?: $this->uniqueSlug($baseSlug);

                    NewsItem::updateOrCreate(
                        ['url' => $url],
                        [
                            'slug'         => $slugFinal,
                            'title'        => $title,
                            'excerpt'      => $excerptFinal,
                            'source'       => $sourceName,
                            'published_at' => $publishedAt,
                        ]
                    );

                    $insertedOrUpdated++;
                }
            } catch (\Throwable $e) {
                $this->error("Gagal memproses feed: " . $e->getMessage());
            }
        }

        $this->info("Berita drone berhasil diupdate dari sumber nasional. Total: {$insertedOrUpdated}");
        return Command::SUCCESS;
    }

    /**
     * Pastikan slug unik.
     */
    private function uniqueSlug(string $base): string
    {
        $slug = $base;
        $i = 2;

        while (NewsItem::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
