<?php

use App\Models\Profile;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(LazilyRefreshDatabase::class);

test('guests cannot access profile management', function () {
    $this->get(route('admin.profiles.index'))
        ->assertRedirect(route('admin.login'));
});

test('an authenticated admin can create the portfolio profile with media', function () {
    Storage::fake('public');

    $response = $this
        ->withSession(['admin_authenticated' => true])
        ->post(route('admin.profiles.store'), profilePayload([
            'profile_image' => UploadedFile::fake()->image('profile.jpg', 800, 800),
            'resume' => UploadedFile::fake()->create('resume.pdf', 300, 'application/pdf'),
        ]));

    $response->assertRedirect(route('admin.profiles.index'))
        ->assertSessionHas('success');

    $profile = Profile::query()->firstOrFail();

    expect($profile->name)->toBe('Shamsur Rahman')
        ->and($profile->skills)->toBe(['Laravel', 'PHP', 'MySQL'])
        ->and($profile->services)->toHaveCount(1)
        ->and($profile->profile_image)->not->toBeNull()
        ->and($profile->resume)->not->toBeNull();

    Storage::disk('public')->assertExists($profile->profile_image);
    Storage::disk('public')->assertExists($profile->resume);
});

test('only one portfolio profile can be created', function () {
    Profile::factory()->create();

    $this->withSession(['admin_authenticated' => true])
        ->post(route('admin.profiles.store'), profilePayload())
        ->assertSessionHasErrors('name');

    expect(Profile::query()->count())->toBe(1);
});

test('profile validation rejects invalid media and contact links', function () {
    $this->withSession(['admin_authenticated' => true])
        ->from(route('admin.profiles.create'))
        ->post(route('admin.profiles.store'), profilePayload([
            'email' => 'invalid-email',
            'facebook_url' => 'not-a-url',
            'github_url' => 'not-a-url',
            'profile_image' => UploadedFile::fake()->create('profile.pdf', 100, 'application/pdf'),
            'resume' => UploadedFile::fake()->image('resume.jpg'),
        ]))
        ->assertRedirect(route('admin.profiles.create'))
        ->assertSessionHasErrors(['email', 'facebook_url', 'github_url', 'profile_image', 'resume']);
});

test('an authenticated admin can update profile content and replace media', function () {
    Storage::fake('public');

    $oldImage = UploadedFile::fake()->image('old-profile.jpg')->store('profiles/images', 'public');
    $oldResume = UploadedFile::fake()->create('old-resume.pdf', 100, 'application/pdf')->store('profiles/resumes', 'public');
    $profile = Profile::factory()->create([
        'profile_image' => $oldImage,
        'resume' => $oldResume,
    ]);

    $response = $this
        ->withSession(['admin_authenticated' => true])
        ->put(route('admin.profiles.update', $profile), profilePayload([
            'name' => 'Updated Engineer',
            'profile_image' => UploadedFile::fake()->image('new-profile.webp'),
            'resume' => UploadedFile::fake()->create('new-resume.pdf', 150, 'application/pdf'),
        ]));

    $response->assertRedirect(route('admin.profiles.index'));

    $profile->refresh();

    expect($profile->name)->toBe('Updated Engineer')
        ->and($profile->profile_image)->not->toBe($oldImage)
        ->and($profile->resume)->not->toBe($oldResume);
    Storage::disk('public')->assertMissing($oldImage);
    Storage::disk('public')->assertMissing($oldResume);
    Storage::disk('public')->assertExists($profile->profile_image);
    Storage::disk('public')->assertExists($profile->resume);
});

test('an authenticated admin can remove profile media', function () {
    Storage::fake('public');

    $image = UploadedFile::fake()->image('profile.jpg')->store('profiles/images', 'public');
    $resume = UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf')->store('profiles/resumes', 'public');
    $profile = Profile::factory()->create([
        'profile_image' => $image,
        'resume' => $resume,
    ]);

    $this->withSession(['admin_authenticated' => true])
        ->put(route('admin.profiles.update', $profile), profilePayload([
            'remove_profile_image' => '1',
            'remove_resume' => '1',
        ]))
        ->assertRedirect(route('admin.profiles.index'));

    $profile->refresh();

    expect($profile->profile_image)->toBeNull()
        ->and($profile->resume)->toBeNull();
    Storage::disk('public')->assertMissing($image);
    Storage::disk('public')->assertMissing($resume);
});

test('profile content is rendered dynamically on the frontend', function () {
    $profile = Profile::factory()->create([
        'name' => 'Dynamic Portfolio Name',
        'hero_title_line_one' => 'Backend',
        'hero_title_line_two' => 'Architect',
        'hero_description' => 'Dynamic hero content from the database.',
        'contact_title' => 'Dynamic contact heading',
        'skills' => ['Laravel', 'Redis'],
        'profile_caption' => 'This caption should not be rendered.',
        'facebook_url' => 'https://facebook.com/example',
        'instagram_url' => 'https://instagram.com/example',
        'github_url' => 'https://github.com/example',
        'linkedin_url' => 'https://linkedin.com/in/example',
        'medium_url' => 'https://medium.com/@example',
        'resume' => 'profiles/resumes/dynamic-resume.pdf',
    ]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee($profile->name)
        ->assertSee('Backend')
        ->assertSee('Architect')
        ->assertSee('Dynamic hero content from the database.')
        ->assertSee('Dynamic contact heading')
        ->assertSee('Redis')
        ->assertSee('View resume')
        ->assertSee(route('resume.show'), false)
        ->assertSee('https://facebook.com/example', false)
        ->assertSee('https://instagram.com/example', false)
        ->assertSee('https://github.com/example', false)
        ->assertSee('https://linkedin.com/in/example', false)
        ->assertSee('https://medium.com/@example', false)
        ->assertSee('fa-facebook-f', false)
        ->assertSee('fa-instagram', false)
        ->assertSee('fa-github', false)
        ->assertSee('fa-linkedin-in', false)
        ->assertSee('fa-medium', false)
        ->assertDontSee('This caption should not be rendered.');
});

test('the public resume endpoint serves an uploaded resume', function () {
    Storage::fake('public');

    $resume = UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf')->store('profiles/resumes', 'public');
    Profile::factory()->create(['resume' => $resume]);

    $this->get(route('resume.show'))
        ->assertSuccessful()
        ->assertHeader('content-disposition', 'inline; filename="Shamsur-Rahman-Resume.pdf"');
});

test('footer social icons remain clickable when personal links are not configured', function () {
    Profile::factory()->create();

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('href="https://www.facebook.com/"', false)
        ->assertSee('href="https://www.instagram.com/"', false)
        ->assertSee('href="https://github.com/"', false)
        ->assertSee('href="https://www.linkedin.com/"', false)
        ->assertSee('href="https://medium.com/"', false)
        ->assertDontSee('footer-social-link is-disabled', false);
});

test('deleting the profile removes its uploaded media', function () {
    Storage::fake('public');

    $image = UploadedFile::fake()->image('profile.jpg')->store('profiles/images', 'public');
    $resume = UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf')->store('profiles/resumes', 'public');
    $profile = Profile::factory()->create([
        'profile_image' => $image,
        'resume' => $resume,
    ]);

    $this->withSession(['admin_authenticated' => true])
        ->delete(route('admin.profiles.destroy', $profile))
        ->assertRedirect(route('admin.profiles.index'));

    $this->assertModelMissing($profile);
    Storage::disk('public')->assertMissing($image);
    Storage::disk('public')->assertMissing($resume);
});

/**
 * @param  array<string, mixed>  $overrides
 * @return array<string, mixed>
 */
function profilePayload(array $overrides = []): array
{
    return array_merge([
        'name' => 'Shamsur Rahman',
        'brand_initials' => 'SR',
        'professional_title' => 'Software Engineer',
        'header_subtitle' => 'Laravel and full-stack web',
        'availability_text' => 'Available for engineering work',
        'seo_description' => 'Software Engineer portfolio.',
        'hero_title_line_one' => 'Software',
        'hero_title_line_two' => 'Engineer',
        'hero_description' => 'Professional hero description.',
        'profile_caption' => 'Reliable engineering delivery.',
        'current_focus' => 'Laravel systems',
        'core_strengths' => 'Backend and APIs',
        'orbit_skills' => 'PHP, MySQL, REST',
        'hero_metrics' => [
            ['value' => '5+', 'label' => 'years of experience'],
        ],
        'about_title' => 'About section title',
        'about_paragraph_one' => 'First about paragraph.',
        'about_paragraph_two' => 'Second about paragraph.',
        'about_highlights' => [
            ['title' => 'Backend', 'description' => 'Laravel backend systems.'],
        ],
        'skills_title' => 'Skills section title',
        'skills' => 'Laravel, PHP, MySQL',
        'services_title' => 'Services section title',
        'services' => [
            ['title' => 'API development', 'description' => 'Reliable REST API development.'],
        ],
        'projects_title' => 'Projects section title',
        'experience_title' => 'Experience section title',
        'experiences' => [
            ['period' => '2024 - Present', 'title' => 'Software Engineer', 'description' => 'Building Laravel products.'],
        ],
        'contact_title' => 'Contact section title',
        'contact_description' => 'Contact section description.',
        'email' => 'hello@example.com',
        'phone' => '+1 000 000 0000',
        'location' => 'Remote',
        'facebook_url' => 'https://facebook.com/example',
        'instagram_url' => 'https://instagram.com/example',
        'github_url' => 'https://github.com/example',
        'linkedin_url' => 'https://linkedin.com/in/example',
        'medium_url' => 'https://medium.com/@example',
        'x_url' => 'https://x.com/example',
    ], $overrides);
}
