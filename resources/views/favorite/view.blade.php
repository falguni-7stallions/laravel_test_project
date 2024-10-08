<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Wishlist Products') }}
            <a href="{{ url('/view-products') }}" class="float-end"><i class="fa fa-shopping-basket fa-lg"></i></a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($favoriteItems->isEmpty())
                    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg col-span-4">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <p>You have no favorite products.</p>
                        </div>
                    </div>
                @else
                    @foreach($favoriteItems as $item)
                        <div class="bg-white dark:bg-gray-800 shadow-md rounded-md overflow-hidden flex flex-col">
                            <div class="flex-grow p-4">
                                <h3 class="text-lg font-bold">{{ $item->product->name }}</h3>
                                @if($item->product->image)
                                    <img src="{{ asset('uploads/products/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-48 object-cover rounded-md mb-2">
                                @endif
                                <p class="card-text font-semibold">${{ $item->product->price }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
