<?php

namespace App\Http\Controllers;

use App\Enums\BlogPostStatus;
use App\Http\Requests\StoreBlogPostRequest;
use App\Models\BlogPost;
use App\Services\PostCreationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminBlogPostController extends Controller
{
    public function __construct(private PostCreationService $creationService)
    {
    }

    public function create(): View
    {
        return view('admin.posts.create', [
            'statusOptions' => BlogPostStatus::cases(),
        ]);
    }

    public function store(StoreBlogPostRequest $request): RedirectResponse
    {
        $this->creationService->create(auth()->user(), $request->validated());

        return redirect()
            ->route('admin.posts.create')
            ->with('status', 'Article créé avec succès. Pensez à le publier dès que vous êtes prêt.');
    }
}
