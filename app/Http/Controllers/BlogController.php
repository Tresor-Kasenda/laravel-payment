<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\User;
use App\Services\PaymentOptions;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $posts = BlogPost::published()
            ->with('author')
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('blog.index', [
            'posts' => $posts,
        ]);
    }

    public function show(Request $request, BlogPost $blogPost): View|RedirectResponse
    {
        if ($this->requiresPayment($request->user(), $blogPost)) {
            return redirect()
                ->route('blog.payment.form', $blogPost)
                ->with('payment_prompt', 'Veuillez finaliser le paiement pour accéder à cet article.');
        }

        return view('blog.show', [
            'blogPost' => $blogPost,
            'countryCodes' => PaymentOptions::countryCodes(),
            'planOptions' => PaymentOptions::planOptions(),
        ]);
    }

    private function requiresPayment(?User $user, BlogPost $blogPost): bool
    {
        if (! $blogPost->visible_to_subscribers_only) {
            return false;
        }

        if ($user && ($user->hasActiveSubscription() || $user->id === $blogPost->author_id)) {
            return false;
        }

        return true;
    }
}
