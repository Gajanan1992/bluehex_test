<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="">
                        <div class="w-full mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ __('Posts') }}
                            </h3>

                        </div>
                        {{-- post create form in tailwind --}}
                        <form action="{{ route('posts.update', $post->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Name -->
                            <div>
                                <x-label for="title" :value="__('Title')" />

                                <x-input id="title" class="block mt-1 w-full" type="text" name="title"
                                    :value="$post->title" autofocus />
                                @error('title')
                                    <span class="text-red-500 text-sm" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Categories -->
                            <div>
                                <x-label for="categories" :value="__('Category')" />

                                <x-select id="categories" class="block mt-2 w-full" name="categories[]">
                                    <option value="">{{ __('Select Category') }} </option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ in_array($category->id, $post->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </x-select>
                                @error('categories')
                                    <span class="text-red-500 text-sm" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <!-- Body -->
                            <div class="mt-4">
                                <x-label for="body" :value="__('Body')" />

                                <x-textarea class="block mt-1 w-full" name="body" :value="$post->body">
                                    <x-slot name="cols">3</x-slot>
                                    <x-slot name="rows">10</x-slot>
                                </x-textarea>
                                @error('body')
                                    <span class="text-red-500 text-sm" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                    href="{{ route('posts.index') }}">
                                    {{ __('Cancel') }}
                                </a>

                                <x-button class="ml-4">
                                    {{ __('Submit') }}
                                </x-button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
