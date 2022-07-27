<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="">
                        @include('common.alert')
                        <div class="w-full mb-2 flex justify-between">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ __('Posts') }}
                            </h3>
                            <div class="flex-1 flex justify-end items-center">
                                <a href="{{ route('posts.create') }}"
                                    class="px-4 py-2 bg-blue-500 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                                    {{ __('Create') }}
                                </a>
                            </div>
                        </div>
                        <div class="overflow-x-auto relative">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">
                                            #
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Post Title
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Author
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Categories
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Created At
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="py-3 px-6">
                                                {{ $loop->iteration }}
                                            </th>
                                            <th scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500">
                                                    {{ $post->title }}
                                                </a>
                                            </th>
                                            <td class="py-4 px-6">
                                                {{ $post->user->name }}
                                            </td>
                                            <td class="py-4 px-6">
                                                @foreach ($post->categories as $category)
                                                    <span class="inline-block bg-gray-100 text-sm px-2 rounded-full">
                                                        {{ $category->name ?? 'No Category' }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ $post->created_at->format('d M Y') }}
                                            </td>
                                            <td class="py-4 px-6">

                                                <a href="{{ route('posts.edit', $post->id) }}"
                                                    class="text-sm text-blue-500 dark:text-white hover:text-blue-700 focus:outline-none focus:shadow-outline">
                                                    Edit
                                                </a>
                                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                                    class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-sm text-red-500 dark:text-white hover:text-red-700 focus:outline-none focus:shadow-outline">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-5">
                                {{ $posts->links() }}

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
