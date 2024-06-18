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
            <div class="flex flex-row items-center justify-between">
                <h2 class="text-xl font-bold mb-4">Sesi Mendatang</h2>
                @if (Auth::user()->RoleId == 1 || Auth::user()->RoleId == 3)
                    <a href="{{ route('sessions.request') }}" class="mb-4 inline-block bg-accent text-white py-2 px-4 rounded">Request Sesi</a>
                @endif
                @if (Auth::user()->RoleId == 2 || Auth::user()->RoleId == 3)
                    <a href="{{ route('sessions.available') }}" class="mb-4 inline-block bg-accent text-white py-2 px-4 rounded">Sesi Tersedia</a>
                @endif
            </div>

            @forelse ($upcomingSessions as $session)
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
                        @if (Auth::user()->RoleId == 1)
                            <p class="m-1">👤: {{ $session->mentor ? $session->mentor->UserName : 'Coming Soon' }}</p>
                        @elseif (Auth::user()->RoleId == 2)
                            <p class="m-1">👤: {{ $session->mentee ? $session->mentee->UserName : 'Coming Soon' }}</p>
                        @endif
                    </div>
                    @if ($session->MeetingLink)
                        <a href="{{ $session->MeetingLink }}" target="_blank" class="inline-block bg-green-500 text-white py-2 px-4 rounded">Join Meeting</a>
                    @else
                        <button class="inline-block bg-gray-500 text-white py-2 px-4 rounded cursor-not-allowed" disabled>Join Meeting</button>
                    @endif
                </div>
            @empty
                <p>Tidak ada sesi mendatang.</p>
            @endforelse
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="flex items-center cursor-pointer justify-between" id="toggle-previous-sessions">
                <h2 class="text-xl font-bold mb-4">Sesi Sebelumnya</h2>
                <span id="arrow" class="ml-2 text-xl mb-3">&#x25C0;</span>
            </div>
            <div id="previous-sessions" class="hidden">
                @forelse ($previousSessions as $session)
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
                            @if (Auth::user()->RoleId == 1)
                                <p class="m-1">👤: {{ $session->mentor ? $session->mentor->UserName : 'Coming Soon' }}</p>
                            @elseif (Auth::user()->RoleId == 2)
                                <p class="m-1">👤: {{ $session->mentee ? $session->mentee->UserName : 'Coming Soon' }}</p>
                            @endif
                        </div>
                        <div>
                            @if (Auth::user()->RoleId == 1)
                                @if ($session->MenteeReview)
                                    <button class="inline-block bg-blue-500 text-white py-2 px-4 rounded" onclick="openModal('reviewModal-{{ $session->TrMentoringScheduleId }}', 'View Review')">View Review</button>
                                @else
                                    <button class="inline-block bg-btnprimary text-white py-2 px-4 rounded" onclick="openModal('reviewModal-{{ $session->TrMentoringScheduleId }}', 'Add Review')">Add Review</button>
                                @endif
                            @endif
                            <button class="inline-block bg-gray-500 text-white py-2 px-4 rounded cursor-not-allowed" disabled>Join Meeting</button>
                        </div>
                    </div>

                    <!-- Review Modal -->
                    <div id="reviewModal-{{ $session->TrMentoringScheduleId }}" class="modal hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center">
                        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
                            <h2 class="text-xl font-bold mb-4" id="modalTitle-{{ $session->TrMentoringScheduleId }}"></h2>
                            <form method="POST" action="{{ route('sessions.storeReview', $session) }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="MenteeReview" class="block font-bold text-xl text-gray-700">Review</label>
                                    <textarea class="mt-1 block w-full border-2 border-accent rounded-lg p-2" id="MenteeReview" name="MenteeReview" rows="4" {{ $session->MenteeReview ? 'readonly' : '' }}>{{ old('MenteeReview', $session->MenteeReview) }}</textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="button" onclick="closeModal('reviewModal-{{ $session->TrMentoringScheduleId }}')" class="bg-gray-500 text-white py-2 px-4 rounded mr-2">Cancel</button>
                                    <button type="submit" class="py-2 px-4 rounded text-white {{ $session->MenteeReview ? 'bg-gray-500 cursor-not-allowed' : 'bg-blue-500' }}" {{ $session->MenteeReview ? 'disabled' : '' }}>Submit Review</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <p>Tidak ada sesi sebelumnya.</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function openModal(modalId, title) {
            document.getElementById(modalId).classList.remove('hidden');
            document.getElementById('modalTitle-' + modalId.split('-')[1]).innerText = title;
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        document.getElementById('toggle-previous-sessions').addEventListener('click', function() {
            var previousSessions = document.getElementById('previous-sessions');
            var arrow = document.getElementById('arrow');
            if (previousSessions.classList.contains('hidden')) {
                previousSessions.classList.remove('hidden');
                arrow.innerHTML = '&#x25BC;';
            } else {
                previousSessions.classList.add('hidden');
                arrow.innerHTML = '&#x25C0;';
            }
        });
    </script>
</x-layout>
