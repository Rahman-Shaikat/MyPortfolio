<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class LlmsController extends Controller
{
    public function __invoke(): Response
    {
        $content = view('frontend.llms')->render();

        return response($content, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
