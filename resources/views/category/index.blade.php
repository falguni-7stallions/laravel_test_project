<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Products') }}
            <x-danger-button x-data="" class="btn btn-primary float-end" x-on:click.prevent="$dispatch('open-modal', 'addNewModal')">{{ __('Add New') }}</x-danger-button>
{{--            <a href="{{route('category.create')}}" class="btn btn-primary float-end" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'addNewModal' }))">Add New</a>--}}
        </h2>
    </x-slot>
    <x-modal name="addNewModal" :show="false" maxWidth="lg" id="addNewModal">
        <!-- Include the form from form.blade.php -->
        @include('category.form')
    </x-modal>
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
                            <th>status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ \App\Models\category::getStatus($category->status) }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="text-muted btn btn-transparent btn-xs dropdown-toggle"  id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            {{--                                                <li><a href="{{ route('products.show', $product->id) }}" class="dropdown-item"><i class="fa fa-eye"></i> View</a></li>--}}
{{--                                            <li><a href="{{ route('category.edit', $category->id) }}" class="dropdown-item"><i class="fa fa-pencil"></i> Edit</a></li>--}}
                                            <li>
                                                <x-danger-button class="dropdown-item"
                                                        type="button"
                                                                 x-data=""
                                                        x-on:click.prevent="$dispatch('open-modal', 'addNewModal');
                                                    $nextTick(() => {
                                                        const modal = document.getElementById('addNewModal');
                                                        const form = document.querySelector('form');
                                                        if (form){
                                                        console.log(form);
                                                        console.log($event.target.dataset.name);
                                                            form.setAttribute('action', '{{ route('category.edit', $category->id) }}');
                                                            form.name.value = $event.target.dataset.name; // Using data attributes
                                                            form.status.value = $event.target.dataset.status; // Using data attribute
                                                        }else {
                                                            console.error('Form not found');
                                                        }

                                                    })" data-name="{{ $category->name }}"
                                                                 data-status="{{ $category->status }}">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </x-danger-button>
                                            </li>
                                            <form method="POST" action="{{ route('category.destroy', $category->id) }}" onsubmit="return confirm('Are you sure you want to delete this Product?');">
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
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
