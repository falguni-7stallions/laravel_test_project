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
                    <div class="card mt-3 shadow-lg rounded-md overflow-hidden flex flex-col" onclick="openProductModal({{ $product->id }})">
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
                                <p class="card-text font-semibold">Price: ${{ $product->price }}</p>
                            </div>
                        </div>
                        <a href="#" class="btn btn-outline-danger m-3" onclick="addToCart({{ $product->id }})">Add to Cart</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="d-flex">
                        <!-- Product Image -->
                        <div class="flex-shrink-0">
                            <img id="product-image" src="" alt="Product Image" class="img-fluid" style="width: 200px; height: auto;">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <strong id="product-name" class="mb-1" style="font-size: 25px;">Product Name</strong>
                            <p class="text-danger fw-bold" id="product-price">₹489.00</p>
                            <br />
                            <p id="product-description" class="mb-2">Product description goes here.</p>

                            <!-- Quantity Control -->
{{--                            <div class="d-flex align-items-center mb-2">--}}
{{--                                <button class="btn btn-outline-secondary btn-sm" onclick="decrementQuantity()">-</button>--}}
{{--                                <input type="number" id="quantity" value="1" class="form-control mx-2" style="width: 60px; text-align: center;">--}}
{{--                                <button class="btn btn-outline-secondary btn-sm" onclick="incrementQuantity()">+</button>--}}
{{--                            </div>--}}

                            <button type="button" class="btn btn-outline-danger" onclick="addToCart(modalProductId)">Add To Cart</button>
                        </div>
                    </div>
                </div>
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

    let modalProductId = null;

    function openProductModal(productId) {
        // Make an AJAX request to fetch the product details
        fetch(`/product/${productId}`)
            .then(response => response.json())
            .then(product => {
                // Set the product details in the modal
                modalProductId = product.id;
                document.getElementById('product-name').innerText = product.name;
                document.getElementById('product-image').src = product.image;
                document.getElementById('product-description').innerText = product.description;
                document.getElementById('product-price').innerText = `Price: $${product.price}`;

                // Show the modal
                var myModal = new bootstrap.Modal(document.getElementById('productModal'), {
                    backdrop: 'static',   // Prevent closing when clicking outside the modal
                    keyboard: false       // Prevent closing when pressing 'Esc'
                });
                myModal.show();
            })
            .catch(error => {
                console.error('Error fetching product details:', error);
                alert('Could not load product details.');
            });
    }

</script>
