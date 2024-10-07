<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{--            {{ __('Cart') }}--}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    there is something wrong or you canceled the payment. Please try again.
                    <div class="row p-6">

                        <a href="{{url('/view-products')}}" class="btn btn-primary">product Page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
