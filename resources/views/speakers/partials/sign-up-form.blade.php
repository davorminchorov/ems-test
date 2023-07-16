<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Speaker Sign Up') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Sign up as a speaker to be able to submit a talk proposal.") }}
        </p>
    </header>

    <form method="post" action="{{ route('speakers.sign-up') }}" class="mt-6 space-y-6">
        @csrf
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>
        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <x-text-area id="bio" name="bio" class="mt-1 block w-full" :value="old('bio')" required autocomplete="bio" />
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Sign Up') }}</x-primary-button>
        </div>
    </form>
</section>
