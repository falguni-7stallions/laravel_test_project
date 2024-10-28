<x-app-layout>
    {{--@extends('layouts.app')--}}

    {{--@section('content')--}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{isset($product) ? __('Edit Product') : __('Add Product') }}
            <a href="{{url('products')}}" class="btn btn-primary float-end">Back</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form method="post" action="{{isset($product) ? route('products.update', $product->id) : route('products.store')}}" class="mt-6 space-y-6" enctype="multipart/form-data">

                        @csrf
                        @if(isset($product))
                            @method('PUT')
                        @endif

                        <div>
                            <x-input-label for="name" :value="__('Product Name')" />
                            <x-text-input type="text" class="mt-1 block w-full" id="name" name="name" :value="old('name', $product->name ?? '')" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="category_id" :value="__('Category')" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full">
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ (isset($product) && $product->category_id == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                        </div>
                        <div>
                            <x-input-label for="image" :value="__('Product Image')"/>
                            <x-text-input type="file" class="mt-1 block w-full" id="image" name="image" :value="old('image', $product->image ?? '')"/>
                            @if (isset($product) && $product->image)
                                <div class="mt-4">
                                    <img src="{{ asset('uploads/products/' . $product->image) }}" alt="Product Image" class="w-32 h-32 object-cover">
                                </div>
                            @endif
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-area rows="3" class="mt-1 block w-full" id="description" name="description" :value="old('description', $product->description ?? '')"></x-text-area>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>
                        <div>
                            <x-input-label for="price" :value="__('Product Price')"/>
                            <x-text-input type="number" step="0.01" class="mt-1 block w-full" id="price" name="price" :value="old('city', $product->price ?? '')"/>
                            <x-input-error class="mt-2" :messages="$errors->get('price')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
