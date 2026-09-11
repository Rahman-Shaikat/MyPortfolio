<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Publication;
use App\Services\SeoService;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(SeoService $seoService): Response
    {
        $projects = Project::query()->active()->orderByDesc('updated_at')->get(['slug', 'updated_at']);
        $publications = Publication::query()->published()->orderByDesc('updated_at')->get(['slug', 'updated_at']);

        return response()
            ->view('frontend.sitemap', compact('projects', 'publications', 'seoService'))
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
