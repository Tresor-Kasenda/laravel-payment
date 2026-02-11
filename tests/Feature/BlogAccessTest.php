<?php

use App\Enums\BlogPostStatus;
use App\Enums\SubscriptionStatus;
use App\Models\BlogPost;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('redirects guests of subscriber-only articles to the payment page', function () {
    $post = BlogPost::factory()->create([
        'status' => BlogPostStatus::Published,
        'visible_to_subscribers_only' => true,
        'published_at' => now(),
    ]);

    get(route('blog.show', $post))
        ->assertRedirect(route('blog.payment.form', $post));
});

it('redirects authenticated users without a subscription to the payment page', function () {
    $user = User::factory()->create();
    $post = BlogPost::factory()->create([
        'status' => BlogPostStatus::Published,
        'visible_to_subscribers_only' => true,
        'published_at' => now(),
    ]);

    $this->actingAs($user)
        ->get(route('blog.show', $post))
        ->assertRedirect(route('blog.payment.form', $post));
});

it('lets subscribers view protected articles after payment', function () {
    $user = User::factory()->create();

    Subscription::factory()->create([
        'user_id' => $user->id,
        'status' => SubscriptionStatus::Active,
        'started_at' => now()->subMonth(),
        'renews_at' => now()->addMonth(),
    ]);

    $post = BlogPost::factory()->create([
        'status' => BlogPostStatus::Published,
        'visible_to_subscribers_only' => true,
        'published_at' => now(),
        'content' => 'Contenu premium pour les membres.',
    ]);

    $this->actingAs($user)
        ->get(route('blog.show', $post))
        ->assertOk()
        ->assertSeeText('Contenu premium pour les membres.')
        ->assertSeeText($post->title);
});
