<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Products') }}
            <a href="{{url('cart')}}"><i class="fa fa-shopping-cart fa-lg float-end"></i></a>
            <a href="{{route('favorites.view')}}"><i class="fa fa-heart fa-lg text-danger float-end mr-4"></i></a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($products as $product)
                    <div class="card mt-3 shadow-lg rounded-md overflow-hidden flex flex-col">
                        <div class="flex-grow">
                            <div class="card-body p-4">
                                <h3 class="text-lg font-bold">{{ $product->name }}
                                    <div class="float-end">
                                        <a onclick="addToFavorite({{ $product->id }})">
                                            <i class="{{ in_array($product->id, $wishlistItems) ? 'fa fa-heart text-danger' : 'fa fa-heart-o' }}"></i>
                                        </a>
                                    </div>
                                </h3>
                                @if($product->image)
                                    <img src="{{ asset('uploads/products/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-md mb-2">
                                @endif
                                <p class="card-text">{{ $product->description }}</p>
                                <p class="card-text font-semibold">${{ $product->price }}</p>
                            </div>
                        </div>
                        <a href="#" class="btn btn-success m-3" onclick="addToCart({{ $product->id }})">Add to Cart</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


</x-app-layout>

<script>
    function addToCart(productId) {
        fetch(`/cart/add`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                product_id: productId
            })
        }).then(response => response.json())
            .then(data => alert(data.success));
    }

    function addToFavorite(productId) {
        fetch(`/favorite/add`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                product_id: productId
            })
        }).then(response => response.json())
            .then(data =>  {
                // alert(data.success);
                location.reload();
            });
    }
</script>
