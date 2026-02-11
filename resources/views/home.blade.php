<x-layouts.app>
    <div class="space-y-10">
        @livewire('blog-post-index')

        @auth
            <section class="grid gap-4 md:grid-cols-2">
                <div class="md:col-span-2">
                    @livewire('subscription-dashboard')
                </div>
            </section>
        @endauth
    </div>
</x-layouts.app>
