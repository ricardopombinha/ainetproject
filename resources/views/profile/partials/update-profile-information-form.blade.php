@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
    $admin_access = $admin_access ?? 'False';
@endphp
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    @if($admin_access == 'False')
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
    @else
    <form method="post" action="{{ route('profile.updateAdmin', ['user' => $user]) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
    @endif
        @csrf
        @method('patch')

        <div>
            <!--<x-input-label for="name" :value="__('Name')" />-->
            <!--<x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />-->
            <x-field.input id="name" name="name"  type="text" label="Name" :readonly="$readonly"
            :value="old('name', $user->name)"/>
            <!--<x-input-error class="mt-2" :messages="$errors->get('name')" />-->
        </div>

        <div>
            <!--<x-input-label for="email" :value="__('Email')" />-->
            <!--<x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />-->
            <x-field.input id="email" name="email"  type="email" label="Email" :readonly="$readonly"
            :value="old('email', $user->email)"/>
            <!--<x-input-error class="mt-2" :messages="$errors->get('email')" />-->

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        
        @if($user->type == 'C')
        <x-field.input name="nif" label="Nif" :readonly="$readonly"
            value="{{ $user?->customer?->nif }}"/>
        <x-field.radio-group name="payment_type" label="Type of payment" width="md" :readonly="$readonly"
            value="{{ $user?->customer?->payment_type }}"
            :options="[
                'VISA' => 'Visa',
                'PAYPAL' => 'Paypal',
                'MBWAY' => 'MBWay',
                'Nenhum',
            ]"/>
        <x-field.input name="payment_ref" label="Payment Reference" :readonly="$readonly"
            value="{{ $user?->customer?->payment_ref }}"/>
        @endif
        @if($mode == 'edit')
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
        @else
        @endif
        <div class="pb-6">
            <x-field.image
                name="photo_file"
                label="Photo"
                width="md"
                :readonly="$readonly"
                deleteTitle="Delete Photo"
                :deleteAllow="($mode == 'edit') && ($user->photo_filename)"
                deleteForm="form_to_delete_image"
                :imageUrl="$user->photoFullUrl"/>
        </div>
    </form>
</section>
