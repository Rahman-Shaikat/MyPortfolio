<?php

use App\Models\HabitTrackerPage;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(LazilyRefreshDatabase::class);

function habitPagePayload(array $overrides = []): array
{
    return array_merge([
        'video_url' => 'https://youtu.be/_N37glNeUms?si=example',
        'usd_regular_price' => '15', 'usd_offer_price' => '5',
        'bdt_regular_price' => '1800', 'bdt_offer_price' => '500',
    ], $overrides);
}

test('habit tracker administration is hidden from guests', function () {
    $this->get(route('admin.habit-tracker.edit'))->assertNotFound();
    $this->put(route('admin.habit-tracker.update'), habitPagePayload())->assertNotFound();
    expect(HabitTrackerPage::count())->toBe(0);
});

test('admin sees page info and dropdown without creating records on read', function () {
    $this->withSession(['admin_authenticated' => true])->get(route('admin.habit-tracker.edit'))
        ->assertSuccessful()->assertSee('Page Info')->assertSee('habitTrackerDesktopMenu')->assertSee('habitTrackerMobileMenu');
    expect(HabitTrackerPage::count())->toBe(0);
});

test('admin creates and updates one page record with all four images', function () {
    Storage::fake('public');
    $payload = habitPagePayload();
    foreach (HabitTrackerPage::IMAGE_FIELDS as $field => $label) {
        $payload[$field] = UploadedFile::fake()->image($field.'.png', 1200, 800);
    }
    $this->withSession(['admin_authenticated' => true])->put(route('admin.habit-tracker.update'), $payload)
        ->assertSessionHasNoErrors()->assertRedirect(route('admin.habit-tracker.edit'));
    $page = HabitTrackerPage::findOrFail(1);
    foreach (HabitTrackerPage::IMAGE_FIELDS as $field => $label) {
        Storage::disk('public')->assertExists($page->{$field});
    }
    $images = $page->only(array_keys(HabitTrackerPage::IMAGE_FIELDS));
    $this->put(route('admin.habit-tracker.update'), habitPagePayload(['usd_offer_price' => '7.25']))
        ->assertSessionHasNoErrors()->assertRedirect();
    expect(HabitTrackerPage::count())->toBe(1)
        ->and($page->refresh()->usd_offer_price)->toBe('7.25')
        ->and($page->only(array_keys(HabitTrackerPage::IMAGE_FIELDS)))->toBe($images);
});

test('replacing and removing images cleans storage and restores fallbacks', function () {
    Storage::fake('public');
    $old = UploadedFile::fake()->image('old.png')->store('habit-tracker', 'public');
    $page = HabitTrackerPage::factory()->create(['hero_image' => $old]);
    $this->withSession(['admin_authenticated' => true])->put(route('admin.habit-tracker.update'), habitPagePayload([
        'hero_image' => UploadedFile::fake()->image('new.png'),
    ]))->assertSessionHasNoErrors();
    Storage::disk('public')->assertMissing($old);
    $new = $page->refresh()->hero_image;
    Storage::disk('public')->assertExists($new);
    $this->put(route('admin.habit-tracker.update'), habitPagePayload(['remove_hero_image' => '1']))->assertSessionHasNoErrors();
    expect($page->refresh()->hero_image)->toBeNull();
    Storage::disk('public')->assertMissing($new);
    $this->get(route('habit-tracker'))->assertSuccessful()->assertSee('planner-window');
});

test('invalid prices videos and uploads do not change saved page info', function () {
    Storage::fake('public');
    $page = HabitTrackerPage::factory()->create();
    $this->withSession(['admin_authenticated' => true])->put(route('admin.habit-tracker.update'), habitPagePayload([
        'video_url' => 'https://youtube.com.evil.example/watch?v=_N37glNeUms',
        'usd_offer_price' => '16', 'bdt_regular_price' => '-1', 'bdt_offer_price' => '1.234',
        'hero_image' => UploadedFile::fake()->create('bad.svg', 10, 'image/svg+xml'),
    ]))->assertSessionHasErrors(['video_url', 'usd_offer_price', 'bdt_regular_price', 'bdt_offer_price', 'hero_image']);
    expect($page->refresh()->usd_offer_price)->toBe('5.00');
    expect(Storage::disk('public')->allFiles())->toBe([]);
});

test('frontend renders saved media and both currencies without hardcoded prices', function () {
    $page = HabitTrackerPage::factory()->create([
        'hero_image' => 'habit-tracker/hero.png', 'planner_image' => 'habit-tracker/planner.png',
        'history_image' => 'habit-tracker/history.png', 'analytics_image' => 'habit-tracker/analytics.png',
        'video_url' => 'https://www.youtube.com/watch?v=abcdefghijk',
        'usd_regular_price' => '24', 'usd_offer_price' => '8.50',
        'bdt_regular_price' => '2000', 'bdt_offer_price' => '600',
    ]);
    $response = $this->get(route('habit-tracker'))->assertSuccessful()
        ->assertSee('$8.50')->assertSee('$24.00')->assertSee('65% OFF')
        ->assertSee('70% OFF')->assertSee('abcdefghijk?playsinline=1', false)
        ->assertDontSee('planner-window')->assertDontSee('history-row')->assertDontSee('$15.00');
    foreach (HabitTrackerPage::IMAGE_FIELDS as $field => $label) {
        $response->assertSee(asset('storage/'.$page->{$field}), false);
    }
    expect($page->displayPrices()['USD']['decimals'])->toBe('');
});

test('supported youtube links normalize to a safe video id', function (string $url, ?string $id) {
    expect(HabitTrackerPage::youtubeId($url))->toBe($id);
})->with([
    ['https://youtu.be/_N37glNeUms?si=test', '_N37glNeUms'],
    ['https://www.youtube.com/watch?v=_N37glNeUms&feature=share', '_N37glNeUms'],
    ['https://youtube.com/shorts/_N37glNeUms', '_N37glNeUms'],
    ['https://www.youtube-nocookie.com/embed/_N37glNeUms', '_N37glNeUms'],
    ['https://youtube.com/watch?v[]=bad', null],
    ['https://example.com/_N37glNeUms', null],
]);
