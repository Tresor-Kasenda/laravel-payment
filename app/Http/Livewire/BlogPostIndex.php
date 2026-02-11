<?php

namespace App\Http\Livewire;

use App\Models\BlogPost;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class BlogPostIndex extends Component
{
    public function render(): View
    {
        $user = auth()->user();

        $posts = BlogPost::published()
            ->with('author')
            ->accessibleForUser($user)
            ->orderByDesc('published_at')
            ->get();

        $subscriberPostsCount = BlogPost::published()
            ->where('visible_to_subscribers_only', true)
            ->count();

        return view('livewire.blog-post-index', [
            'posts' => $posts,
            'subscriberPostsCount' => $subscriberPostsCount,
            'userHasSubscription' => $user?->hasActiveSubscription() ?? false,
        ]);
    }

    public function refreshPosts(): void
    {
        $this->emitSelf('refresh');
    }
}
