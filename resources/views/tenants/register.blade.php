<x-tenant-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tenants Register') }}
        </h2>
    </x-slot>
    <div class="flex justify-center items-center">
        <div class="max-w-md w-full">
            <form method="POST" action="{{ route('tenants.store') }}">
                @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
                <!-- Name -->
                <div class="mt-4">
                    <x-input-label for="Company Name" :value="__('Company Name')" />
                    <x-text-input id="Company Name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')"
                        required autofocus autocomplete="Company Name" />
                    <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                </div>

                <!-- domain Address -->
                <div class="mt-4">
                    <x-input-label for="domain" :value="__('domain')" />
                    <div class="flex justify-center items-center">

                    <x-text-input id="domain" class="block mt-1 w-full" type="text" name="domain"
                        :value="old('domain')" required autocomplete="domain" />
                        {{".".config('tenancy.central_domains')[2]}}
                    </div>
                    <x-input-error :messages="$errors->get('domain')" class="mt-2" />
                </div>



                <div class="flex items-center justify-end mt-4">


                    <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-tenant-layout>
