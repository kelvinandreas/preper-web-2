<x-layout>
    <header class="bg-accent relative h-36">
        <div class="absolute bottom-0 px-5">
            <div class="text-bgc gap-5 flex flex-1 flex-col-reverse sm:flex-row justify-between items-end px=5">
                <p class="text-9xl font-extrabold">Available Sessions</p>
            </div>
        </div>
    </header>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <h2 class="text-xl font-bold mb-4">Available Sessions</h2>
            @forelse ($availableSessions as $session)
                <div class="mb-4 p-4 border border-gray-200 rounded-md">
                    <p>Session ID: {{ $session->id }}</p>
                    <p>Schedule Time: {{ $session->scheduleTime }}</p>
                    <form action="{{ route('sessions.accept', $session) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded">Accept</button>
                    </form>
                </div>
            @empty
                <p>No available sessions.</p>
            @endforelse
        </div>
    </div>
</x-layout>
