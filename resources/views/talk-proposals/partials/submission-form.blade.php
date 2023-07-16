<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Talk Proposal Submission') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Submit a talk proposal to speak at the event.") }}
        </p>
    </header>

    <form method="post" action="{{ route('talk-proposals.submit') }}" class="mt-6 space-y-6">
        @csrf
        <div>
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autocomplete="title" />
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>
        <div>
            <x-input-label for="abstract" :value="__('Abstract')" />
            <x-text-area id="abstract" name="abstract" class="mt-1 block w-full" :value="old('abstract')" required autocomplete="abstract" />
            <x-input-error class="mt-2" :messages="$errors->get('abstract')" />
        </div>
        <div>
            <x-input-label for="preferred_time_slot" :value="__('Preferred Time Slot')" />
            <x-text-input id="preferred_time_slot" name="preferred_time_slot" type="time" class="mt-1 block w-full" :value="old('preferred_time_slot')" required autocomplete="preferred_time_slot" />
            <x-input-error class="mt-2" :messages="$errors->get('preferred_time_slot')" />
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Submit') }}</x-primary-button>
        </div>
    </form>
</section>
