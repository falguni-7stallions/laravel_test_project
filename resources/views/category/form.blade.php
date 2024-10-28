<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <form class="mt-6 space-y-6" id="categoryForm">
                    @csrf

                    <div>
                        <input type="hidden" name="category_id" id="category_id">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input type="text" class="mt-1 block w-full" id="name" name="name" :value="old('name', $category->name ?? '')"/>
{{--                        <x-input-error class="mt-2" :messages="$errors->get('name')" />--}}
                    </div>
                    <div>
                        <x-input-label for="status" :value="__('Status')" />
                        <select name="status" id="status" class="form-control">
                            <option value="">Select...</option>
                            @foreach (\App\Models\category::getStatus() as $key => $value)
                                <option value="{{ $key }}" {{ isset($category) && $category->status == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
{{--                        <x-input-error class="mt-2" :messages="$errors->get('status')" />--}}
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button id="submitBtn">{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
