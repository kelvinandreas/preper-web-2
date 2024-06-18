<x-layout>
    <header class="bg-accent relative h-36">
        <div class="absolute bottom-0 px-5">
            <div class="text-bgc gap-5 flex flex-1 flex-col-reverse sm:flex-row justify-between items-end px=5">
                <p class="text-9xl font-extrabold">Sessions</p>
            </div>
        </div>
    </header>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <h2 class="text-xl font-bold mb-4">Upcoming Sessions</h2>
            @forelse ($upcomingSessions as $session)
                <div class="mb-4 p-4 border border-gray-200 rounded-md">
                    <p>Session ID: {{ $session->id }}</p>
                    <p>Schedule Time: {{ $session->scheduleTime }}</p>
                </div>
            @empty
                <p>No upcoming sessions.</p>
            @endforelse

            @if (Auth::user()->RoleId == 1)
                <a href="{{ route('sessions.request') }}" class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded">Request Session</a>
            @elseif (Auth::user()->RoleId == 2)
                <a href="{{ route('sessions.available') }}" class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded">Available Sessions</a>
            @endif
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <h2 class="text-xl font-bold mb-4">Previous Sessions</h2>
            @forelse ($previousSessions as $session)
                <div class="mb-4 p-4 border border-gray-200 rounded-md">
                    <p>Session ID: {{ $session->id }}</p>
                    <p>Schedule Time: {{ $session->scheduleTime }}</p>
                </div>
            @empty
                <p>No previous sessions.</p>
            @endforelse
        </div>
    </div>
</x-layout>
