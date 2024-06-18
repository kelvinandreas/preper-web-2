<x-layout>
    <header class="bg-accent relative h-36">
        <div class="absolute bottom-0 px-5">
            <div class="text-bgc gap-5 flex flex-1 flex-col-reverse sm:flex-row justify-between items-end px=5">
                <p class="text-9xl font-extrabold">Sesi</p>
            </div>
        </div>
    </header>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <h2 class="text-xl font-bold mb-4">Sesi Tersedia</h2>
            @forelse ($availableSessions as $session)
                @php
                    $meetingStart = \Carbon\Carbon::parse($session->MeetingTime);
                    $meetingEnd = $meetingStart->copy()->addMinutes(100);
                @endphp
                <div class="mb-4 p-4 border border-gray-200 rounded-md flex justify-between items-center">
                    <div>
                        <p class="m-1 font-bold text-lg">{{ $session->UniqueCode }}</p>
                        <p class="m-1">
                            <span class="mr-1">📅</span>{{ $meetingStart->format('Y-m-d') }} -
                            <span class="ml-1 mr-1">⏰</span>{{ $meetingStart->format('H:i') }} - {{ $meetingEnd->format('H:i') }}
                        </p>
                        <p class="m-1">Topik: {{ $session->SpecificTopic }}</p>
                        <p class="m-1">Mentee: {{ $session->mentee ? $session->mentee->UserName : 'Coming Soon' }}</p>
                    </div>
                    <form action="{{ route('sessions.accept', $session) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded">Terima</button>
                    </form>
                </div>
            @empty
                <p>Tidak ada sesi saat ini.</p>
            @endforelse
        </div>
    </div>
</x-layout>
