<?php

namespace App\Models;

use Database\Factories\HabitTrackerPageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabitTrackerPage extends Model
{
    /** @use HasFactory<HabitTrackerPageFactory> */
    use HasFactory;

    public const IMAGE_FIELDS = [
        'hero_image' => 'Main app preview',
        'planner_image' => 'Monthly planning',
        'history_image' => 'Progress history',
        'analytics_image' => 'Progress analytics',
    ];

    protected $fillable = [
        'id',
        'hero_image', 'planner_image', 'history_image', 'analytics_image',
        'video_url', 'usd_regular_price', 'usd_offer_price', 'bdt_regular_price', 'bdt_offer_price',
    ];

    protected $attributes = [
        'video_url' => 'https://youtu.be/_N37glNeUms',
        'usd_regular_price' => '15.00', 'usd_offer_price' => '5.00',
        'bdt_regular_price' => '1800.00', 'bdt_offer_price' => '500.00',
    ];

    protected function casts(): array
    {
        return [
            'usd_regular_price' => 'decimal:2', 'usd_offer_price' => 'decimal:2',
            'bdt_regular_price' => 'decimal:2', 'bdt_offer_price' => 'decimal:2',
        ];
    }

    public static function youtubeId(string $url): ?string
    {
        $parts = parse_url($url);
        if (! is_array($parts) || ! in_array(strtolower($parts['scheme'] ?? ''), ['http', 'https'], true)) {
            return null;
        }
        $host = strtolower($parts['host'] ?? '');
        $path = trim($parts['path'] ?? '', '/');
        $id = null;
        if (in_array($host, ['youtu.be', 'www.youtu.be'], true)) {
            $id = $path;
        } elseif (in_array($host, ['youtube.com', 'www.youtube.com', 'm.youtube.com', 'youtube-nocookie.com', 'www.youtube-nocookie.com'], true)) {
            parse_str($parts['query'] ?? '', $query);
            if ($path === 'watch') {
                $id = $query['v'] ?? null;
            } elseif (preg_match('~^(?:embed|shorts|live)/([^/]+)$~', $path, $matches)) {
                $id = $matches[1];
            }
        }

        return is_string($id) && preg_match('/^[A-Za-z0-9_-]{11}$/', $id) ? $id : null;
    }

    public function videoEmbedUrl(): string
    {
        return 'https://www.youtube-nocookie.com/embed/'.self::youtubeId($this->video_url).'?playsinline=1&rel=0';
    }

    /** @return array<string, array<string, string>> */
    public function displayPrices(): array
    {
        $prices = [];
        foreach (['USD' => '$', 'BDT' => "\u{09F3}"] as $currency => $symbol) {
            $prefix = strtolower($currency);
            $regular = (float) $this->getAttribute($prefix.'_regular_price');
            $offer = (float) $this->getAttribute($prefix.'_offer_price');
            $offerDecimals = floor($offer) === $offer ? 0 : 2;
            $regularDecimals = floor($regular) === $regular ? 0 : 2;
            $prices[$currency] = [
                'offer' => $symbol.number_format($offer, $offerDecimals),
                'regular' => $symbol.number_format($regular, $regularDecimals),
                'regularFull' => $symbol.number_format($regular, 2),
                'decimals' => $currency === 'USD' && $offerDecimals === 0 ? '.00' : '',
                'discount' => (string) round((1 - $offer / max($regular, 0.01)) * 100).'% OFF',
                'currency' => $currency,
            ];
        }

        return $prices;
    }
}
