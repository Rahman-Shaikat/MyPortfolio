<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\SeoService;
use Illuminate\Http\Response;

class LlmsController extends Controller
{
    public function __invoke(SeoService $seoService): Response
    {
        $content = view('frontend.llms', compact('seoService'))->render();

        return response($content, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
