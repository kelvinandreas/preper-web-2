<x-layout>
    <header class="bg-accent relative h-36">
        <div class="absolute bottom-0 px-5">
            <div class="text-bgc gap-5 flex flex-1 flex-col-reverse sm:flex-row justify-between items-end px=5">
                <p class="text-9xl font-extrabold">permintaan sesi</p>
            </div>
        </div>
    </header>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" x-data="{ selectedSubject: null }">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <form method="POST" action="{{ route('sessions.storeRequest') }}" class="space-y-6">
                @csrf

                <div>
                    <x-input-label for="fullName" :value="__('Nama lengkap')" />
                    <x-text-input id="fullName" name="fullName" type="text" class="mt-1 block w-full border-2 border-accent rounded-lg p-2 bg-accent text-white" value="{{ Auth::user()->UserName }}" readonly />
                </div>

                <div>
                    <x-input-label for="whatsapp" :value="__('No WhatsApp')" />
                    <x-text-input id="whatsapp" name="whatsapp" type="text" class="mt-1 block w-full border-2 border-accent rounded-lg p-2 bg-accent text-white" value="{{ Auth::user()->UserPhoneNumber }}" readonly />
                </div>

                <div>
                    <x-input-label :value="__('Pilih topik yang ingin anda pelajari:')" />
                    @foreach($subjects as $subject)
                        <div class="form-check mb-2">
                            <input
                                class="mr-2 hidden"
                                type="radio"
                                id="subject{{ $subject->SubjectId }}"
                                name="subject"
                                value="{{ $subject->SubjectId }}"
                                x-model="selectedSubject"
                            >
                            <label class="form-check-label flex items-center gap-2 cursor-pointer" for="subject{{ $subject->SubjectId }}">
                                <div
                                    :class="{ 'bg-accent': selectedSubject == '{{ $subject->SubjectId }}', 'border border-accent': selectedSubject != '{{ $subject->SubjectId }}' }"
                                    class="inline-block h-5 w-5 rounded-md border-2"
                                ></div>
                                <span>{{ $subject->SubjectName }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>

                <div>
                    <x-input-label for="specificTopic" :value="__('Hal spesifik apa yang ingin anda bahas?')" />
                    <x-text-input id="specificTopic" name="specificTopic" type="text" class="mt-1 block w-full border-2 border-accent rounded-lg p-2" required />
                </div>

                {{-- <div>
                    <x-input-label :value="__('Pilih batch untuk (dd-mm-yyyy):')" />
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input class="mr-2" type="radio" id="batch1" name="batch" value="Batch 1" required>
                            <label for="batch1">Batch 1 (07:20 - 09:00)</label>
                        </div>
                        <div>
                            <input class="mr-2" type="radio" id="batch2" name="batch" value="Batch 2" required>
                            <label for="batch2">Batch 2 (09:20 - 11:00)</label>
                        </div>
                        <div>
                            <input class="mr-2" type="radio" id="batch3" name="batch" value="Batch 3" required>
                            <label for="batch3">Batch 3 (11:20 - 13:00)</label>
                        </div>
                        <div>
                            <input class="mr-2" type="radio" id="batch4" name="batch" value="Batch 4" required>
                            <label for="batch4">Batch 4 (13:20 - 15:00)</label>
                        </div>
                        <div>
                            <input class="mr-2" type="radio" id="batch5" name="batch" value="Batch 5" required>
                            <label for="batch5">Batch 5 (15:20 - 17:00)</label>
                        </div>
                        <div>
                            <input class="mr-2" type="radio" id="batch6" name="batch" value="Batch 6" required>
                            <label for="batch6">Batch 6 (17:20 - 19:00)</label>
                        </div>
                    </div>
                </div> --}}
                <div x-data="{ selectedBatch: null }" class="mb-3">
                    <x-input-label :value="__('Pilih batch untuk (dd-mm-yyyy):')" />
                    <div class="grid grid-cols-2 gap-4">
                        @php
                            $batches = [
                                ['value' => 'Batch 1', 'label' => 'Batch 1 (07:20 - 09:00)'],
                                ['value' => 'Batch 2', 'label' => 'Batch 2 (09:20 - 11:00)'],
                                ['value' => 'Batch 3', 'label' => 'Batch 3 (11:20 - 13:00)'],
                                ['value' => 'Batch 4', 'label' => 'Batch 4 (13:20 - 15:00)'],
                                ['value' => 'Batch 5', 'label' => 'Batch 5 (15:20 - 17:00)'],
                                ['value' => 'Batch 6', 'label' => 'Batch 6 (17:20 - 19:00)'],
                            ];
                        @endphp

                        @foreach($batches as $batch)
                        <div>
                            <input type="radio" id="batch{{ $loop->index + 1 }}" name="batch" value="{{ $batch['value'] }}" x-model="selectedBatch" class="hidden">
                            <label for="batch{{ $loop->index + 1 }}" class="form-check-label flex items-center gap-2 cursor-pointer">
                                <div :class="{ 'bg-accent': selectedBatch == '{{ $batch['value'] }}', 'border border-accent': selectedBatch != '{{ $batch['value'] }}' }" class="inline-block h-5 w-5 rounded-md border-2"></div>
                                <span>{{ $batch['label'] }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>


                <div class="flex items-center justify-end">
                    <x-primary-button>{{ __('Selesai') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
    <script src="//unpkg.com/alpinejs" defer></script>
</x-layout>
