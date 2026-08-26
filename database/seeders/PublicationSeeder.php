<?php

namespace Database\Seeders;

use App\Models\Publication;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PublicationSeeder extends Seeder
{
    public function run(): void
    {
        $title = 'BaSCo: A Benchmark for Evaluating Social Bias and Cultural Commonsense in Bangla LLMs';

        Publication::query()->updateOrCreate(['slug' => Str::slug($title)], [
            'title' => $title,
            'authors' => ['Afsara Tasnim', 'Md. Shamsur Rahman', 'Ajwad Abrar'],
            'publisher' => 'MusIML Workshop, ICML 2026',
            'published_at' => null,
            'description' => 'BaSCo is a benchmark for evaluating social bias and cultural commonsense in Bangla large language models, supporting research on responsible AI, low-resource-language evaluation, and culturally grounded LLM assessment.',
            'url' => config('seo.research.openreview_url'),
            'reference_url' => config('seo.research.scholar_url'),
            'research_topics' => [
                'Bangla Large Language Models',
                'LLM Evaluation',
                'Social Bias',
                'Cultural Commonsense',
                'Responsible AI',
                'Benchmark Development',
            ],
            'contribution' => null,
            'sort_order' => 1,
            'status' => true,
        ]);
    }
}
