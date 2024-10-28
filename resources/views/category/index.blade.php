<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Category') }}
            <button class="btn btn-primary float-end" id="createNewCategory">{{ __('Add New') }}</button>
        </h2>
    </x-slot>
{{--    <div x-data="categoryModal()" x-init="init()">--}}
    <div class="modal fade" id="ajaxModel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('category.form')
                </div>
            </div>
        </div>
    </div>

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
                                                <li><a href="#" class="dropdown-item editCategory" data-id="{{$category->id}}"><i class="fa fa-pencil"></i> Edit</a></li>
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
{{--    </div>--}}

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#createNewCategory').click(function () {
                $('#name').val('');
                $('#status').val('');
                $('#categoryForm').trigger("reset");
                $('#modelHeading').html("<i class='fa fa-plus'></i> Add New Category");
                $('#ajaxModel').modal('show');
                // $('#nameError').text('');
            });

            $('#categoryForm').submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                let category_id = $('#category_id').val();
                let name = $('#name').val();
                let status = $('#status').val();
                console.log(name);
                console.log(status);

                formData.append('name', name);
                formData.append('status', status);
                if (category_id) {
                    formData.append('_method', 'PUT');
                }

                let ajaxUrl = category_id ? "{{ url('category') }}/" + category_id : "{{ route('category.store') }}";
                let ajaxType = "POST";

                $('#submitBtn').html('Sending...');

                $.ajax({
                    type:ajaxType,
                    url: ajaxUrl,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        console.log(ajaxUrl);
                        $('#submitBtn').html('Submit');
                        $('#categoryForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        location.reload();
                    },
                    error: function(response){
                        $('#submitBtn').html('Submit');
                        console.log("Error Response:", response);
                        if (response.responseJSON && response.responseJSON.message) {
                            alert("Error: " + response.responseJSON.message);
                        } else {
                            alert("An unexpected error occurred.");
                        }
                    }
                });

            });

            //edit
            $('body').on('click', '.editCategory', function () {
                var category_id = $(this).data('id');
                $.get("{{ route('category.index') }}" +'/' + category_id +'/edit', function (data) {
                    $('#modelHeading').html("<i class='fa fa-pencil'></i> Edit Category");
                    $('#submitBtn').val("Save");
                    $('#ajaxModel').modal('show');
                    $('#category_id').val(data.id);
                    $('#name').val(data.name);
                    $('#status').val(data.status);
                })
            });
        });
    </script>
</x-app-layout>


