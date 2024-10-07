<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cart') }}
            <a href="{{ url('/view-products') }}" class="float-end"><i class="fa fa-shopping-basket fa-lg"></i></a>
            <a href="{{ route('favorites.view') }}"><i class="fa fa-heart fa-lg text-danger float-end mr-4"></i></a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(count($cartItems) > 0)
                        @foreach($cartItems as $item)
                            <div class="flex items-start border-b py-4">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('uploads/products/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="rounded-md w-32 h-32 object-cover">
                                </div>
                                <div class="ml-4 flex-grow">
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-lg font-bold">{{ $item->product->name }}</h3>
                                        <a onclick="deleteCart({{ $item->id }})" class="text-red-600 hover:text-red-800">
                                            <i class="fa fa-remove"></i>
                                        </a>
                                    </div>
                                    <p>Quantity: {{ $item->quantity }}</p>
                                    <p class="font-semibold">Total: ${{ $item->quantity * $item->product->price }}</p>
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-6 flex justify-between items-center">
                            <strong class="text-lg">Total Amount: ${{ $total }}</strong>
                            <form action="{{ route('checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Checkout</button>
                            </form>
                        </div>
                    @else
                        <div class="text-center mt-5">
                            <div class="text-lg font-semibold">Your cart is Empty</div>
                            <br>
                            <a href="{{ url('/view-products') }}" class="btn btn-primary">Go to Product Page</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function deleteCart(itemId) {
        if (confirm('Are you sure you want to remove this item?')) {
            $.ajax({
                url: '/cart/' + itemId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'  // CSRF token for security
                },
                success: function(response) {
                    // alert(response.success); // Show success message
                    location.reload();
                },
                error: function(response) {
                    alert('Error occurred while removing item from cart');
                }
            });
        }
    }
</script>
