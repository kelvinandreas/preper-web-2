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
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Sesi Tersedia</h2>
                @if (!auth()->user()->IsValid)
                    <p class="text-sm text-red-500">
                        *Anda belum terverifikasi, sehingga anda belum bisa menerima sesi mentoring.
                    </p>
                @endif
            </div>
            @forelse ($availableSessions as $session)
                @php
                    $meetingStart = \Carbon\Carbon::parse($session->MeetingTime);
                    $meetingEnd = $meetingStart->copy()->addMinutes(100);
                @endphp
                <div class="mb-4 p-4 border border-gray-200 rounded-md flex justify-between items-center">
                    <div>
                        <p class="m-1 font-bold text-lg">{{ $session->UniqueCode }}</p>
                        <p class="m-1">
                            <span class="mr-1">📅</span>{{ $meetingStart->format('Y-m-d') }}
                            <span class="ml-1 mr-1">⏰</span>{{ $meetingStart->format('H:i') }} - {{ $meetingEnd->format('H:i') }}
                        </p>
                        <p class="m-1">📚: {{ $session->SpecificTopic }}</p>
                        <p class="m-1">Mentee: {{ $session->mentee ? $session->mentee->UserName : 'Coming Soon' }}</p>
                    </div>
                    <form action="{{ route('sessions.accept', $session) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="py-2 px-4 rounded
                                       {{ auth()->user()->IsValid ? 'bg-green-500 text-white' : 'bg-gray-500 text-white cursor-not-allowed' }}"
                                @if (!auth()->user()->IsValid)
                                    disabled
                                @endif>
                            Terima
                        </button>
                    </form>
                </div>
            @empty
                <p>Tidak ada sesi saat ini.</p>
            @endforelse
        </div>
    </div>
</x-layout>
