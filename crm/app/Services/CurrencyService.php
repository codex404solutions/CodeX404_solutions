<?php
declare(strict_types=1);

namespace CRM\Services;

/**
 * CurrencyService handles real-time live exchange rate fetching, caching,
 * and currency conversions for multi-currency CRM operations (USD, INR, EUR, GBP, AED, CAD, AUD, SGD).
 */
class CurrencyService
{
    private const CACHE_FILE = 'rates_cache.json';
    private const CACHE_TTL_SECONDS = 3600; // 1 hour

    /**
     * Fallback rates in case network or external API is temporarily unavailable
     */
    private const DEFAULT_RATES = [
        'USD' => 1.0,
        'INR' => 95.05,
        'EUR' => 0.8915,
        'GBP' => 0.7511,
        'AED' => 3.6725,
        'CAD' => 1.4100,
        'AUD' => 1.4325,
        'SGD' => 1.2798,
        'JPY' => 158.44
    ];

    public const CURRENCIES = [
        'USD' => ['code' => 'USD', 'symbol' => '$',   'flag' => '🇺🇸', 'name' => 'US Dollar',        'locale' => 'en-US'],
        'INR' => ['code' => 'INR', 'symbol' => '₹',   'flag' => '🇮🇳', 'name' => 'Indian Rupee',     'locale' => 'en-IN'],
        'EUR' => ['code' => 'EUR', 'symbol' => '€',   'flag' => '🇪🇺', 'name' => 'Euro',             'locale' => 'en-US'],
        'GBP' => ['code' => 'GBP', 'symbol' => '£',   'flag' => '🇬🇧', 'name' => 'British Pound',    'locale' => 'en-GB'],
        'AED' => ['code' => 'AED', 'symbol' => 'د.إ', 'flag' => '🇦🇪', 'name' => 'UAE Dirham',       'locale' => 'en-US'],
        'CAD' => ['code' => 'CAD', 'symbol' => 'C$',  'flag' => '🇨🇦', 'name' => 'Canadian Dollar',  'locale' => 'en-CA'],
        'AUD' => ['code' => 'AUD', 'symbol' => 'A$',  'flag' => '🇦🇺', 'name' => 'Australian Dollar','locale' => 'en-AU'],
        'SGD' => ['code' => 'SGD', 'symbol' => 'S$',  'flag' => '🇸🇬', 'name' => 'Singapore Dollar', 'locale' => 'en-SG'],
    ];

    /**
     * Get live or cached exchange rates with USD as the base currency
     */
    public static function getRates(): array
    {
        $cached = StorageService::read(self::CACHE_FILE);
        $now = time();

        if (
            is_array($cached) &&
            !empty($cached['rates']) &&
            isset($cached['updated_at']) &&
            ($now - (int)$cached['updated_at']) < self::CACHE_TTL_SECONDS
        ) {
            return $cached['rates'];
        }

        // Try to fetch live rates from free open exchange API (2 second timeout)
        $liveRates = self::fetchLiveRates();
        if (!empty($liveRates)) {
            StorageService::write(self::CACHE_FILE, [
                'updated_at' => $now,
                'source' => 'https://open.er-api.com/v6/latest/USD',
                'rates' => $liveRates
            ]);
            return $liveRates;
        }

        // Return previous cache or default rates if fetch failed
        if (is_array($cached) && !empty($cached['rates'])) {
            return $cached['rates'];
        }

        return self::DEFAULT_RATES;
    }

    /**
     * Fetch live rates from open exchange API
     */
    private static function fetchLiveRates(): ?array
    {
        $url = 'https://open.er-api.com/v6/latest/USD';
        
        // Fast cURL fetch
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 2,
                CURLOPT_CONNECTTIMEOUT => 2,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_USERAGENT => 'CodeX404-CRM-CurrencyEngine/1.0'
            ]);
            $response = curl_exec($ch);
            curl_close($ch);

            if ($response) {
                $data = json_decode((string)$response, true);
                if (is_array($data) && ($data['result'] ?? '') === 'success' && !empty($data['rates'])) {
                    return $data['rates'];
                }
            }
        }

        return null;
    }

    /**
     * Convert an amount from USD to a target currency
     */
    public static function convert(float $amountInUSD, string $targetCurrency = 'USD'): float
    {
        $rates = self::getRates();
        $targetCurrency = strtoupper(trim($targetCurrency));
        $rate = (float)($rates[$targetCurrency] ?? 1.0);
        return $amountInUSD * $rate;
    }
}
