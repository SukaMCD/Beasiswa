<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [
            ['loc' => route('homepage'), 'lastmod' => now()->startOfDay()->toAtomString(), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => route('products'), 'lastmod' => now()->startOfDay()->toAtomString(), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => route('articles'), 'lastmod' => now()->startOfDay()->toAtomString(), 'changefreq' => 'daily', 'priority' => '0.8'],
            ['loc' => route('reviews'), 'lastmod' => now()->startOfDay()->toAtomString(), 'changefreq' => 'monthly', 'priority' => '0.5'],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . $url['loc'] . '</loc>';
            $xml .= '<lastmod>' . $url['lastmod'] . '</lastmod>';
            $xml .= '<changefreq>' . $url['changefreq'] . '</changefreq>';
            $xml .= '<priority>' . $url['priority'] . '</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }
}
