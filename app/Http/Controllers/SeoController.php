<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class SeoController extends Controller
{
    /**
     * Serve robots.txt with the sitemap location of the configured domain.
     */
    public function robots()
    {
        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            'Disallow: /cart',
            'Disallow: /checkout',
            'Disallow: /orders',
            'Disallow: /profile',
            'Disallow: /track-order/',
            'Disallow: /contact/my-messages',
            '',
            'Sitemap: ' . $this->baseUrl() . '/sitemap.xml',
        ];

        return response(implode("\n", $lines) . "\n", 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }

    /**
     * Serve the XML sitemap for all indexable storefront URLs.
     */
    public function sitemap()
    {
        $urls = [];

        $urls[] = $this->entry(route('products.index', [], false), 'daily', '0.9', Product::max('updated_at'));
        $urls[] = $this->entry('/', 'daily', '1.0', now());

        foreach (Category::where('is_active', true)->orderBy('sort_order')->get() as $category) {
            $urls[] = $this->entry(
                route('products.byCategory', $category->id, false),
                'weekly',
                '0.7',
                $category->updated_at
            );
        }

        Product::where('is_active', true)
            ->orderByDesc('updated_at')
            ->chunk(200, function ($products) use (&$urls) {
                foreach ($products as $product) {
                    $urls[] = $this->entry(
                        route('products.show', $product->id, false),
                        'weekly',
                        '0.8',
                        $product->updated_at
                    );
                }
            });

        $urls[] = $this->entry(route('track-order.index', [], false), 'monthly', '0.3');
        $urls[] = $this->entry(route('privacy-policy', [], false), 'yearly', '0.3');

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= '  <url>';
            $xml .= '<loc>' . e($url['loc']) . '</loc>';
            if ($url['lastmod']) {
                $xml .= '<lastmod>' . $url['lastmod'] . '</lastmod>';
            }
            $xml .= '<changefreq>' . $url['changefreq'] . '</changefreq>';
            $xml .= '<priority>' . $url['priority'] . '</priority>';
            $xml .= '</url>' . "\n";
        }

        $xml .= '</urlset>' . "\n";

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    /**
     * Build a sitemap entry for a relative storefront path.
     */
    private function entry(string $path, string $changefreq, string $priority, $lastmod = null): array
    {
        return [
            'loc' => $this->baseUrl() . '/' . ltrim($path, '/'),
            'changefreq' => $changefreq,
            'priority' => $priority,
            'lastmod' => $lastmod ? \Illuminate\Support\Carbon::parse($lastmod)->toAtomString() : null,
        ];
    }

    /**
     * Canonical site root taken from APP_URL so the sitemap ignores preview hosts.
     */
    private function baseUrl(): string
    {
        return rtrim(config('app.url'), '/');
    }
}
