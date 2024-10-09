{{--<x-app-layout>--}}
    {{--@extends('layouts.app')--}}

    {{--@section('content')--}}
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">--}}
{{--            {{isset($category) ? __('Edit Product') : __('Add Category') }}--}}
{{--            <a href="{{url('category')}}" class="btn btn-primary float-end">Back</a>--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form method="post" action="{{isset($category) ? route('category.update', $category->id) : route('category.store')}}" class="mt-6 space-y-6">

                        @csrf
                        @if(isset($category))
                            @method('PUT')
                        @endif

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input type="text" class="mt-1 block w-full" id="name" name="name" :value="old('name', $category->name ?? '')" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select name="status" id="status" class="form-control">
                                @foreach (\App\Models\category::getStatus() as $key => $value)
                                    <option value="{{ $key }}" {{ isset($category) && $category->status == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

{{--</x-app-layout>--}}
