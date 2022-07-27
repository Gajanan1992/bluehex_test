<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post details') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="">
                        @include('common.alert')
                        <div class="w-full mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ __($post->title) }}
                            </h3>

                        </div>

                        {{-- create post details design --}}
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                {{-- <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="{{ $post->user->avatar }}" alt="">
                                </div> --}}
                                <div class="ml-4">
                                    Author
                                    <div class="text-sm leading-5 font-medium text-gray-900">
                                        {{ $post->user->name }}
                                    </div>
                                    <div class="text-sm leading-5 text-gray-500">
                                        {{ $post->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="mr-2 text-sm leading-5 text-gray-500">
                                    {{ __('Categories :') }}
                                </div>
                                <div class="text-sm leading-5 font-medium text-gray-900">
                                    @foreach ($post->categories as $category)
                                        <span class="inline-block bg-gray-100 text-sm px-2 rounded-full">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <section class="overflow-hidden text-gray-700 ">
                            <div class="container px-5 py-2  lg:pt-12 lg:px-32">
                                <div class="flex flex-wrap -m-1 md:-m-2">
                                    @foreach ($post->photos as $photo)
                                        <div class="flex flex-wrap w-1/3">
                                            <div class="w-full p-1 md:p-2">
                                                <img alt="gallery"
                                                    class="block object-cover object-center w-full h-full rounded-lg"
                                                    src="{{ Storage::url($photo->path) }}">
                                            </div>
                                        </div>
                                    @endforeach
                                    @foreach ($post->videos as $video)
                                        <div class="flex flex-wrap w-1/3">
                                            <div class="w-full p-1 md:p-4">
                                                <video controls autoplay
                                                    class="block object-cover object-center w-full h-full rounded-lg">
                                                    <source src="{{ Storage::url($video->path) }}" type="video/mp4">
                                                </video>
                                                {{-- caption --}}
                                                {{-- <div class="text-sm leading-5 text-gray-500">
                                                    {{ $video->name }}
                                                </div> --}}

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                        {{-- body of post --}}
                        {{-- post create form in tailwind --}}
                        <div class="py-4 w-full">
                            {{ $post->body }}
                        </div>
                        {{-- comment box create comment --}}
                        <div class="flex justify-between items-center">
                            <h2>Comments: ({{ count($post->comments) }})</h2>
                        </div>
                        {{-- comment list --}}
                        <div class="flex flex-col">
                            @foreach ($post->comments as $comment)
                                <div class="flex bg-white shadow-lg rounded-lg mb-4">
                                    <!--horizantil margin is just for display-->
                                    <div class="flex items-start px-4 py-6">

                                        <div class="">
                                            <div class="flex items-center justify-between">
                                                <h2 class="text-lg font-semibold text-gray-900 -mt-1">
                                                    {{ $comment->user->name }} </h2>
                                                {{-- <small class="text-sm text-gray-700">22h ago</small> --}}
                                            </div>
                                            <p class="text-gray-700">{{ $comment->created_at->diffForHumans() }}</p>
                                            <p class="mt-3 text-gray-700 text-sm">
                                                {{ $comment->comment }}
                                            </p>
                                            <div class="mt-5">
                                                <div class="flex flex-wrap -m-1 md:-m-2">
                                                    @foreach ($comment->photos as $photo)
                                                        <div class="flex flex-wrap w-28">
                                                            <div class="w-full p-1 md:p-2">
                                                                <img alt="gallery"
                                                                    class="block object-cover object-center w-full h-full rounded-lg"
                                                                    src="{{ Storage::url($photo->path) }}">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @foreach ($comment->videos as $video)
                                                        <div class="flex flex-wrap w-28">
                                                            <div class="w-full p-1 md:p-4">
                                                                <video controls autoplay
                                                                    class="block object-cover object-center w-full h-full rounded-lg">
                                                                    <source src="{{ Storage::url($video->path) }}"
                                                                        type="video/mp4">
                                                                </video>
                                                                {{-- caption --}}
                                                                {{-- <div class="text-sm leading-5 text-gray-500">
                                                                    {{ $video->name }}
                                                                </div> --}}

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- component -->
                            <!-- post card -->

                            {{-- comment box --}}
                            <div class=" items-center">
                                <h2>Add comment</h2>
                                <form method="POST" action="{{ route('comment.store', $post->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mt-4">
                                        <x-label for="comment" :value="__('Comment')" />

                                        <x-textarea class="block mt-1 w-full" name="comment" :value="old('body')">
                                            <x-slot name="cols">3</x-slot>
                                            <x-slot name="rows">4</x-slot>
                                        </x-textarea>
                                        @error('comment')
                                            <span class="text-red-500 text-sm" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mt-5">
                                        <x-label for="files" :value="__('Upload Image or Videos')" />
                                        <x-input id="files" class="block mt-1 w-full" type="file" name="files[]"
                                            multiple :value="old('file')" />
                                        @error('files')
                                            <span class="text-red-500 text-sm" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="flex items-center justify-end mt-4">
                                        <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                            href="{{ route('posts.index') }}">
                                            {{ __('Back') }}
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
            </div>
</x-app-layout>
