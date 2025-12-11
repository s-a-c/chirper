<!-- @format -->

{{-- Compliant with [.ai/AI-GUIDELINES.md](../../.ai/AI-GUIDELINES.md) v374a22e55a53ea38928957463e1f0ef28f820080a27e0466f35d46c20626fa72 --}}
<!-- @format -->

<x-layout>
    <x-slot:title>Welcome</x-slot:title>

    <div class="mx-auto mt-0 max-w-2xl">
        <div class="card bg-base-100 mt-0 shadow">
            <div class="card-body">
                <div>
                    <h1 class="text-3xl font-bold">Welcome to Chirper!</h1>
                    <p class="text-base-content/60 mt-4">This is your brand new Laravel application. Time to make it sing (or chirp)!</p>
                    <p>This is your brand new Laravel app. Time to make it sing (or chirp)!</p>
                    <p class="mt-2 text-sm text-gray-600">Now this is live on the internet! 🎉</p>
                </div>
            </div>
        </div>
        <p />
        @foreach ($chirps as $chirp)
        <div class="card bg-base-100 mt-4 shadow">
            <div class="card-body">
                <div>
                    <div class="font-semibold">{{ $chirp['author'] }}</div>
                    <div class="mt-1">{{ $chirp['message'] }}</div>
                    <div class="text-sm text-gray-500 mt-2">{{ $chirp['time'] }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-layout>
