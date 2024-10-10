<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Category') }}
            <button x-data="" class="btn btn-primary float-end" x-on:click.prevent="$dispatch('open-modal', 'addNewModal')">{{ __('Add New') }}</button>
        </h2>
    </x-slot>
    <div x-data="categoryModal()" x-init="init()">
        <x-modal name="addNewModal" :show="false" maxWidth="lg" id="addNewModal">
            <div class="modal-header">
                <h5 class="modal-title">Category Form</h5>
                <button type="button" class="btn-close" aria-label="Close" x-on:click.prevent="$dispatch('close-modal', 'addNewModal'); resetForm()"></button>
            </div>
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
                                                <li><a href="#" class="dropdown-item" x-data="" x-on:click.prevent="openForEdit({{ $category->id }})"><i class="fa fa-pencil"></i> Edit</a></li>
                                                <li>
                                                    <form method="POST" action="{{ route('category.destroy', $category->id) }}" onsubmit="return confirm('Are you sure you want to delete this Product?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>

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
    </div>

    <script>
        function categoryModal() {
            return {
                categoryId: null,
                category: { name: '', status: 1 },

                init() {
                    console.log("Category Modal Initialized");
                },

                openForCreate() {
                    this.resetForm(); // Reset the form for new entry
                    this.$dispatch('open-modal', 'addNewModal'); // Open modal
                },

                openForEdit(id) {
                    fetch(`/category/${id}/edit`) // Fetch category data for editing
                        .then(response => response.json())
                        .then(data => {
                            this.categoryId = id;
                            this.category = data; // Store fetched data

                            // Populate form fields
                            document.getElementById('name').value = this.category.name;
                            document.getElementById('status').value = this.category.status;
                            document.getElementById('categoryForm').setAttribute('action', `/category/${id}`); // Set action to update
                            document.getElementById('formMethod').value = 'PUT'; // Set method to PUT
                            document.getElementById('submitBtn').innerText = 'Save'; // Change button text

                            this.$dispatch('open-modal', 'addNewModal'); // Open modal
                        })
                        .catch(error => console.error("Error fetching category data:", error));
                },

                resetForm() {
                    // Reset form fields
                    this.categoryId = null;
                    this.category = { name: '', status: 1 };
                    document.getElementById('name').value = '';
                    document.getElementById('status').value = 1; // Default status
                    document.getElementById('formMethod').value = 'POST'; // Reset to POST for new category
                    document.getElementById('categoryForm').setAttribute('action', '{{ route("category.store") }}'); // Reset action
                    document.getElementById('submitBtn').innerText = 'Save'; // Reset button text
                }
            }
        }
    </script>

</x-app-layout>
