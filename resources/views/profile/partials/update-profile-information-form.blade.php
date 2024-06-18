<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Profile') }}
        </h2>
    </header>
    <div class="p-10" x-data="{ role: '{{ $user->RoleId == 1 ? 'mentee' : 'mentor' }}' }">
        <div class="font-bold">Anda ingin menjadi?</div>
        <div class="mt-5">
            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')

                <div class="role-toggle flex mb-4">
                    <label @click="role = 'mentee'" :class="{ 'bg-btnprimary text-white': role === 'mentee', 'bg-btnaccent text-black': role !== 'mentee' }" class="w-1/2 text-center py-2 cursor-pointer font-bold">
                        <input type="radio" name="role" id="mentee" value="mentee" class="hidden" x-model="role">
                        Mentee
                    </label>
                    <label @click="role = 'mentor'" :class="{ 'bg-btnprimary text-white': role === 'mentor', 'bg-btnaccent text-black': role !== 'mentor' }" class="w-1/2 text-center py-2 cursor-pointer font-bold">
                        <input type="radio" name="role" id="mentor" value="mentor" class="hidden" x-model="role">
                        Mentor
                    </label>
                </div>

                <div>
                    <x-input-label for="UserName" :value="__('UserName')" />
                    <x-text-input id="UserName" name="UserName" type="text" class="mt-1 block w-full border-2 border-accent rounded-lg p-2" :value="old('UserName', $user->UserName)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('UserName')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-2 border-accent rounded-lg p-2" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div>
                    <x-input-label for="whatsapp" :value="__('No WhatsApp')" />
                    <x-text-input id="whatsapp" name="whatsapp" type="text" class="mt-1 block w-full border-2 border-accent rounded-lg p-2" :value="old('UserPhoneNumber', $user->UserPhoneNumber)" />
                    <x-input-error class="mt-2" :messages="$errors->get('UserPhoneNumber')" />
                </div>

                <div>
                    <x-input-label for="point" :value="__('User Point')" />
                    <x-text-input id="point" name="point" type="text" class="mt-1 block w-full rounded-lg p-2 bg-accent text-white tracking-wide" :value="old('UserPoint', $user->UserPoint)" readonly/>
                    <x-input-error class="mt-2" :messages="$errors->get('UserPoint')" />
                </div>

                <div class="mb-3" id="subject-container" :style="{ display: role === 'mentor' ? 'block' : 'none' }" x-data="{ selectedSubject: '{{ $user->SubjectId }}' }">
                    <label class="block mb-2">Pilih topik yang anda kuasai:</label>
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

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'profile-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>
