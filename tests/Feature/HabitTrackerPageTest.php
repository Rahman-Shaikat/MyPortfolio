<?php

use App\Models\Profile;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    config()->set('seo.url', 'https://shaikat.xyz');
    Profile::factory()->create(['name' => 'Md. Shamsur Rahman']);
});

test('habit tracker product page is available from the portfolio navigation', function () {
    $response = $this->get(route('habit-tracker'));

    $response->assertSuccessful()
        ->assertSee('Habit Tracker')
        ->assertSee('Build the routines')
        ->assertSee('that build your life.')
        ->assertSee('Purchase for Windows')
        ->assertSee('Monthly planning')
        ->assertSee('Progress analytics')
        ->assertSee(route('habit-tracker'), false)
        ->assertDontSee('iOS')
        ->assertDontSee('Android');
});

test('habit tracker navigation follows services and is included in the sitemap', function () {
    $home = $this->get(route('home'))->assertSuccessful()->getContent();

    expect(strpos($home, '>Habit Tracker</a>'))->toBeGreaterThan(strpos($home, '>Services</a>'));

    $this->get(route('sitemap'))
        ->assertSuccessful()
        ->assertSee('https://shaikat.xyz/habit-tracker', false);
});
