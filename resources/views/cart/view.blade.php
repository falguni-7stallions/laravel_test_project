<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cart') }}
            <a href="{{url('/view-products')}}" class="float-end"><i class="fa fa-shopping-basket fa-lg"></i></a>
            <a href="{{route('favorites.view')}}"><i class="fa fa-heart fa-lg text-danger float-end mr-4"></i></a>
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
                        <div class="row mt-3">

                            <div class="col-sm-6 col-lg-3 col-12 p-2">
                                <img src="{{ asset('uploads/products/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="rounded-md h-auto w-90">
                            </div>
                            <div class="col-sm-6 col-lg-4 col-12">
                                <a class="float-xl-end" onclick="deleteCart({{ $item->id }})"><i class="fa fa-remove"></i></a>

                                <h3>{{ $item->product->name }}</h3>
                                <p>Quantity: {{ $item->quantity }}</p>
                                <p>Total: ${{ $item->quantity * $item->product->price }}</p>
                            </div>

                            <hr class="p-3">
                        </div>
                    @endforeach
                    <div class="row mt-8 float-end"><strong>total Amount: ${{$total}}</strong><hr class="p-2"> <form action="{{ route('cart.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Checkout</button>
                        </form></div>
                    @else
                        <div class="text-center mt-5">
                            <div>Your cart is Empty</div><br><a href="{{url('/view-products')}}" class="btn btn-primary">product Page</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function deleteCart(itemId) {
        if(confirm('Are you sure you want to remove this item?')) {
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
