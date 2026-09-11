<?php

return [
    'url' => env('SEO_URL', 'https://shaikat.xyz'),
    'site_name' => 'Md. Shamsur Rahman',
    'default_image' => 'assets/images/og/md-shamsur-rahman-og.png',
    'robots' => 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1',
    'enforce_canonical' => filter_var(env('SEO_ENFORCE_CANONICAL', env('APP_ENV') === 'production'), FILTER_VALIDATE_BOOL),

    'verification' => [
        'google' => env('GOOGLE_SITE_VERIFICATION'),
        'bing' => env('BING_SITE_VERIFICATION'),
    ],

    'person' => [
        'name' => 'Md. Shamsur Rahman',
        'alternate_names' => ['Shamsur Rahman', 'Shaikat', 'Rahman Shaikat'],
        'introduction' => 'Also known as Shaikat, I am a software engineer and Laravel developer in Dhaka, Bangladesh. My work as a software developer focuses on reliable web applications, backend systems, and API integrations.',
        'job_title' => 'Software Engineer',
        'specialization' => 'Laravel / PHP Backend Development',
        'location' => 'Dhaka, Bangladesh',
        'description' => 'Software Engineer specializing in Laravel and PHP backend development, production web applications, REST APIs, databases, and software systems, with research interests in artificial intelligence and large language models.',
        'same_as' => [
            'https://www.linkedin.com/in/rahman-shaikat-7254651b7',
            'https://github.com/Rahman-Shaikat',
            'https://scholar.google.com/citations?user=HSHJO28AAAAJ',
        ],
        'knows_about' => [
            'Software Engineering',
            'PHP',
            'Laravel',
            'Backend Development',
            'RESTful APIs',
            'MySQL',
            'Eloquent ORM',
            'Redis',
            'Docker',
            'Database Design',
            'Web Application Development',
            'E-commerce Development',
            'Artificial Intelligence',
            'Large Language Models',
            'Natural Language Processing',
            'LLM Evaluation',
            'Responsible AI',
        ],
    ],

    'research' => [
        'scholar_url' => 'https://scholar.google.com/citations?view_op=view_citation&hl=en&user=HSHJO28AAAAJ&citation_for_view=HSHJO28AAAAJ:d1gkVwhDpl0C',
        'openreview_url' => 'https://openreview.net/forum?id=VvbpOkDEBf',
    ],
];
