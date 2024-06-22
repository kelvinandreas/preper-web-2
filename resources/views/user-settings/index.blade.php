<x-layout>
    <header class="bg-accent relative h-36">
        <div class="absolute bottom-0 px-5">
            <div class="text-bgc">
                <p class="text-9xl"><b>User Settings</b></p>
            </div>
        </div>
    </header>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <h2 class="text-xl font-bold mb-4">User Settings</h2>

            <h3 class="text-lg font-semibold mb-2">Mentors</h3>
            <div class="space-y-4">
                @forelse ($mentors as $mentor)
                    <div class="p-4 border border-gray-200 rounded-md flex justify-between items-center">
                        <div class="flex items-center space-x-6">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                <p>{{ $mentor->UserName }}</p>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-phone mr-2"></i>
                                <p>{{ $mentor->UserPhoneNumber }}</p>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-book mr-2"></i>
                                <p>{{ $mentor->SubjectName }}</p>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-coins mr-2"></i>
                                <p>{{ $mentor->UserPoint }}</p>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2 {{ $mentor->IsValid ? 'text-green-500' : 'text-red-500' }}"></i>
                                <p>{{ $mentor->IsValid ? 'Verified' : 'Not Verified' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <!-- Button to open edit modal -->
                            <button onclick="" class="bg-green-400 text-white py-2 px-4 rounded">View Activity</button>
                            <button onclick="openModal('modal-mentor-{{ $mentor->id }}')" class="bg-blue-500 text-white py-2 px-4 rounded">Edit</button>
                            <form action="{{ route('user.settings.delete', $mentor->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded">Delete</button>
                            </form>
                        </div>
                    </div>
                    <!-- Edit Modal -->
                    <div id="modal-mentor-{{ $mentor->id }}" class="modal hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center">
                        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
                            <h2 class="text-xl font-bold mb-4">Edit Mentor</h2>
                            <form action="{{ route('user.settings.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $mentor->id }}">
                                <div class="mb-4">
                                    <label for="points" class="block text-sm font-medium text-gray-700">Points</label>
                                    <x-text-input id="points" name="points" type="number" class="mt-1 block w-full border-2 border-accent rounded-lg p-2" :value="old('points', $mentor->UserPoint)" required />
                                </div>
                                <div class="mb-4">
                                    <label for="is_valid" class="block text-sm font-medium text-gray-700">Verification Status</label>
                                    <select name="is_valid" id="is_valid" class="mt-1 block w-full border-2 border-accent rounded-lg p-2">
                                        <option value="1" {{ $mentor->IsValid ? 'selected' : '' }}>Verified</option>
                                        <option value="0" {{ !$mentor->IsValid ? 'selected' : '' }}>Not Verified</option>
                                    </select>
                                </div>
                                <div class="flex justify-end">
                                    <button type="button" onclick="closeModal('modal-mentor-{{ $mentor->id }}')" class="bg-gray-500 text-white py-2 px-4 rounded mr-2">Cancel</button>
                                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <p>No mentors available.</p>
                @endforelse
            </div>

            <h3 class="text-lg font-semibold mt-6 mb-2">Mentees</h3>
            <div class="space-y-4">
                @forelse ($mentees as $mentee)
                    <div class="p-4 border border-gray-200 rounded-md flex justify-between items-center">
                        <div class="flex items-center space-x-10">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                <p>{{ $mentee->UserName }}</p>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-phone mr-2"></i>
                                <p>{{ $mentee->UserPhoneNumber }}</p>
                            </div>
                            {{-- <div class="flex items-center">
                                <i class="fas fa-coins mr-2"></i>
                                <p>{{ $mentee->UserPoint }}</p>
                            </div> --}}
                        </div>
                        <div class="flex items-center space-x-2">
                            {{-- <!-- Button to open edit modal -->
                            <button onclick="openModal('modal-mentee-{{ $mentee->id }}')" class="bg-blue-500 text-white py-2 px-4 rounded">Edit</button> --}}
                            <form action="{{ route('user.settings.delete', $mentee->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded">Delete</button>
                            </form>
                        </div>
                    </div>
                    <!-- Edit Modal -->
                    <div id="modal-mentee-{{ $mentee->id }}" class="modal hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center">
                        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
                            <h2 class="text-xl font-bold mb-4">Edit Mentee</h2>
                            <form action="{{ route('user.settings.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $mentee->id }}">
                                <div class="mb-4">
                                    <label for="points" class="block text-sm font-medium text-gray-700">Points</label>
                                    <x-text-input id="points" name="points" type="number" class="mt-1 block w-full border-2 border-accent rounded-lg p-2" :value="old('points', $mentee->UserPoint)" required />
                                </div>
                                <div class="flex justify-end">
                                    <button type="button" onclick="closeModal('modal-mentee-{{ $mentee->id }}')" class="bg-gray-500 text-white py-2 px-4 rounded mr-2">Cancel</button>
                                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <p>No mentees available.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layout>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
</script>
