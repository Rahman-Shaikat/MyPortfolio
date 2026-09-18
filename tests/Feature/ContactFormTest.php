<?php

use App\Mail\ContactInquiryMail;
use App\Models\Profile;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(LazilyRefreshDatabase::class);

test('contact forms submit to a secure application endpoint', function () {
    Profile::factory()->create(['email' => 'owner@example.com']);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee(route('contact.store'), false)
        ->assertDontSee('mailto:', false);

    $this->get(route('contact'))
        ->assertSuccessful()
        ->assertSee(route('contact.store'), false)
        ->assertDontSee('mailto:', false);
});

test('a visitor can send a contact inquiry', function () {
    Mail::fake();
    Profile::factory()->create(['email' => 'owner@example.com']);

    $response = $this->from(route('contact'))->post(route('contact.store'), [
        'name' => 'Jane Engineer',
        'email' => 'jane@example.com',
        'project_type' => 'Laravel application',
        'message' => 'I need help with a Laravel platform.',
        'website' => '',
    ]);

    $response->assertRedirect(route('contact'))
        ->assertSessionHas('contact_success');

    Mail::assertSent(ContactInquiryMail::class, function (ContactInquiryMail $mail): bool {
        return $mail->hasTo('owner@example.com')
            && $mail->senderEmail === 'jane@example.com'
            && $mail->projectType === 'Laravel application';
    });
});

test('contact inquiries reject invalid input and honeypot submissions', function () {
    Profile::factory()->create(['email' => 'owner@example.com']);

    $this->from(route('contact'))->post(route('contact.store'), [
        'name' => '',
        'email' => 'invalid',
        'project_type' => 'Unsupported project',
        'message' => '',
        'website' => 'spam.example',
    ])->assertRedirect(route('contact'))
        ->assertSessionHasErrors(['name', 'email', 'project_type', 'message', 'website']);
});

test('the home page defers heavy research media', function () {
    Profile::factory()->create();

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('data-src="'.asset('assets/videos/3D-2.mp4').'"', false)
        ->assertSee('preload="none"', false)
        ->assertDontSee('<source src="'.asset('assets/videos/3D-2.mp4'), false);
});

test('llms text exposes markdown links', function () {
    $this->get(route('llms'))
        ->assertSuccessful()
        ->assertSee('[Home](https://shaikat.xyz)', false)
        ->assertSee('[GitHub](', false);
});
