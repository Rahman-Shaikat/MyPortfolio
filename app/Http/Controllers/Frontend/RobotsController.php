<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\SeoService;
use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function __invoke(SeoService $seoService): Response
    {
        $content = implode("\n", [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin/',
            'Disallow: /dashboard/',
            'Disallow: /api/',
            '',
            'User-agent: OAI-SearchBot',
            'Allow: /',
            '',
            'User-agent: Claude-SearchBot',
            'Allow: /',
            '',
            'User-agent: Claude-User',
            'Allow: /',
            '',
            'User-agent: Google-Extended',
            'Allow: /',
            '',
            'User-agent: GPTBot',
            'Allow: /',
            '',
            'User-agent: ChatGPT-User',
            'Allow: /',
            '',
            'User-agent: ClaudeBot',
            'Allow: /',
            '',
            'User-agent: PerplexityBot',
            'Allow: /',
            '',
            'Sitemap: '.$seoService->url('sitemap'),
        ]);

        return response($content."\n", 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
