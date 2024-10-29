
<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Send SMS') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <form action="{{ route('sms.send') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <div>
                        <x-input-label for="phone" :value="__('Phone Number')" />
                        <x-text-input type="text" class="mt-1 block w-full" id="phone" name="phone" />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>
                    <div>
                        <x-input-label for="message" :value="__('Message')" />
                        <x-text-area rows="3" class="mt-1 block w-full" id="message" name="message"></x-text-area>
                        <x-input-error class="mt-2" :messages="$errors->get('message')" />
                    </div>
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Send SMS') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
