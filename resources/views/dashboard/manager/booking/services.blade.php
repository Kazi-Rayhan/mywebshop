<x-dashboard.manager>
    @push('styles')
    @livewireStyles
    @endpush
    <div class="d-flex align-items-center">
        <img src="{{ Iziibuy::image($user->avatar) }}" height="80" class="rounded-circle mr-4" alt="">
        <div>
            <h3 class="m-0">{{ $user->fullName }}</h3>
            <a href="mailto:{{$user->email}}">{{$user->email}}</a>
        </div>
    </div>

    <livewire:trainerbooking :user="$user" :session="$session"  :shop="auth()
        ->user()
        ->getShop()" :trainer="auth()->user()" />

    @push('scripts')
    @livewireScripts
    @endpush
</x-dashboard.manager>
