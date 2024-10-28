<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Products') }}
            <a href="{{route('products.create')}}" class="btn btn-primary float-end">Add New</a>
            <a href="{{route('products.export')}}" class="btn btn-outline-dark float-end mr-4">Export</a>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? '-' }}</td>
                                <td>{{ $product->price }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="text-muted btn btn-transparent btn-xs dropdown-toggle"  id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
{{--                                                <li><a href="{{ route('products.show', $product->id) }}" class="dropdown-item"><i class="fa fa-eye"></i> View</a></li>--}}
                                            <li><a href="{{ route('products.edit', $product->id) }}" class="dropdown-item"><i class="fa fa-pencil"></i> Edit</a></li>
                                            <form method="POST" action="{{ route('products.destroy', $product->id) }}" onsubmit="return confirm('Are you sure you want to delete this Product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </ul>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
