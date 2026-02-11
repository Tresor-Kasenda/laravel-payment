<?php

namespace App\Http\Requests;

use App\Enums\BlogPostStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBlogPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin ?? false;
    }

    public function rules(): array
    {
        $allowedStatuses = array_map(
            fn (BlogPostStatus $status) => $status->value,
            BlogPostStatus::cases(),
        );

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:600'],
            'content' => ['required', 'string'],
            'status' => ['required', Rule::in($allowedStatuses)],
            'visible_to_subscribers_only' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'reading_time_minutes' => ['required', 'integer', 'min:1', 'max:240'],
            'featured_image' => ['nullable', 'url'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'visible_to_subscribers_only' => $this->boolean('visible_to_subscribers_only'),
        ]);
    }
}
