<div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{ open: @entangle('modalOpen') }">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="">
                @include('common.alert')
                <div class="w-full mb-2 flex justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ __('Categories') }}
                    </h3>
                    <div class="flex-1 flex justify-end items-center">
                        <a href="#" @click.prevent="open = true"
                            class="px-4 py-2 bg-blue-500 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                            {{ __('Create') }}
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto relative">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    Category Name
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Created At
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    No of posts
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $category->name }}
                                    </th>
                                    <td class="py-4 px-6">
                                        {{ $category->created_at->format('d M Y') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $category->posts->count() }}
                                    </td>

                                    <td class="py-4 px-6">

                                        <a href="#" wire:click.prevent="edit({{ $category->id }})"
                                            class="text-sm text-blue-500 dark:text-white hover:text-blue-700 focus:outline-none focus:shadow-outline">
                                            Edit
                                        </a>

                                        <button type="button" wire:click.prevent="delete({{ $category->id }})"
                                            class="text-sm text-red-500 dark:text-white hover:text-red-700 focus:outline-none focus:shadow-outline">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-5">
                        {{ $categories->links() }}

                    </div>


                </div>

            </div>
        </div>
    </div>
    <!-- Main modal -->
    <div id="defaultModal" tabindex="-1"
        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full justify-center items-center flex shadow-lg "
        aria-modal="true" role="dialog" x-show="open">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ $editMode ? 'Update' : 'Add' }} Category
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="defaultModal" @click="open = false">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <x-label for="name" :value="__('Name')" />

                    <x-input id="name" wire:model.defer="name" class="block mt-1 w-full" type="text"
                        name="name" :value="old('name')" autofocus />
                    @error('name')
                        <span class="text-red-500 text-sm" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                    <button data-modal-toggle="defaultModal" type="button" wire:click="store"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Submit</button>
                    <button data-modal-toggle="defaultModal" @click.prevent="open=false" type="button"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                </div>
            </div>
        </div>
    </div>

</div>
