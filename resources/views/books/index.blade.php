<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between">
                        <div>
                            @if(session('success'))
                            <div id="flash-message"
                                class="px-4 py-2 rounded-md font-medium text-sm bg-green-200 text-green-600 dark:text-green-400">
                                {{ session('success') }}
                            </div>
                            @endif
                        </div>
                        <div>
                            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-book')"
                                type="button"
                                class="bg-green-500 hover:bg-green-700 focus:bg-green-700 active:bg-green-700 shadow">
                                <i class='bx bx-plus'></i><span class="ml-2">New Book</span>
                            </x-primary-button>
                        </div>
                    </div>
                    <div class="text-center mt-8">
                        <table id="books-table" class="table-auto w-full">
                            <thead>
                                <tr>
                                    {{-- <th></th> --}}
                                    <th>Book Name</th>
                                    <th>Author</th>
                                    <th>Book Cover</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODALS --}}
    <x-modal name="add-book" :show="$errors->bookCreation->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="mt-6 grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <x-input-label for="book_name_create" :value="__('Book Name')" />
                    <x-text-input id="book_name_create" name="book_name" type="text" class="mt-1 block w-full"
                        :value="old('book_name')" placeholder="Enter Book Name..." required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->bookCreation->get('book_name')" />
                </div>

                <div class="col-span-12">
                    <x-input-label for="book_author_create" :value="__('Book Author')" />
                    <x-text-input id="book_author_create" name="book_author" type="text" class="mt-1 block w-full"
                        :value="old('book_author')" placeholder="Enter Book Author..." required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->bookCreation->get('book_author')" />
                </div>

                <div class="col-span-12">
                    <x-input-label for="book_cover_photo_create" :value="__('Book Cover Photo')" />
                    <x-text-input id="book_cover_photo_create" name="book_cover_photo" type="file"
                        class="mt-1 block w-full !shadow-none" />
                    <x-input-error class="mt-2" :messages="$errors->bookCreation->get('book_cover_photo')" />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ml-3 bg-green-500 hover:bg-green-700 focus:bg-green-700 active:bg-green-700">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <x-modal name="edit-book" focusable>
        <form method="POST" action="#" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            <div class="mt-6 grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <x-input-label for="book_name_edit" :value="__('Book Name')" />
                    <x-text-input id="book_name_edit" name="book_name" type="text" class="mt-1 block w-full"
                        :value="old('book_name')" placeholder="Enter Book Name..." required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->bookCreation->get('book_name')" />
                </div>

                <div class="col-span-12">
                    <x-input-label for="book_author_edit" :value="__('Book Author')" />
                    <x-text-input id="book_author_edit" name="book_author" type="text" class="mt-1 block w-full"
                        :value="old('book_author')" placeholder="Enter Book Author..." required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->bookCreation->get('book_author')" />
                </div>

                <div class="col-span-12">
                    <x-input-label for="current_book_cover_photo_edit" :value="__('Current Book Cover')" />
                    <img id="current_book_cover_photo_edit" class="shadow mt-1 w-full lg:w-1/2"
                        src="{{ asset('storage/book_covers/choose-img.jpg') }}" alt="Book Cover Name">
                </div>

                <div class="col-span-12">
                    <x-input-label for="book_cover_photo_edit" :value="__('Book Cover Photo')" />
                    <x-text-input id="book_cover_photo_edit" name="book_cover_photo" type="file"
                        class="mt-1 block w-full !shadow-none" />
                    <x-input-error class="mt-2" :messages="$errors->bookCreation->get('book_cover_photo')" />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ml-3 bg-green-500 hover:bg-green-700 focus:bg-green-700 active:bg-green-700">
                    {{ __('Update') }}
                </x-primary-button>
            </div>
            </div>
    </x-modal>

    @push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#books-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('books.index') }}",
                columns: [
                    { data: 'book_name', name: 'book_name' },
                    { data: 'book_author', name: 'book_author' },
                    {
                        data: 'book_cover_photo_path',
                        name: 'book_cover_photo_path',
                        render: function(data, type, full, meta) {
                            return '<img src="' + @js(asset('storage'))+"/"+data + '" alt="Book Cover" class="h-16">';
                        }
                    },
                    { 
                        data: null, 
                        name: 'action',
                        render: function(data, type, full, meta) {
                            return `<div class="flex justify-center space-x-1">
                                <x-primary-button id="editBook-${data.id}" onClick="editBook(${data.id})" type="button" x-on:click.prevent="$dispatch('open-modal', 'edit-book')" class="!px-2 !py-1 bg-blue-500 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-700">
                                    <i class='bx bx-edit-alt text-sm'></i>
                                </x-primary-button>
                                <x-danger-button class="!px-2 !py-1">
                                    <i class='bx bx-trash text-sm'></i>
                                </x-danger-button>
                            </div>` 
                        }
                     },
                ],
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            var flashMessage = document.getElementById('flash-message');
            
            setTimeout(function() {
                if (flashMessage) {
                    flashMessage.style.opacity = '0';
                }
            }, 2000); // 2000 milliseconds (2 seconds) is the duration of the fade-out effect
        });

        function editBook(id = null) {
            $.ajax({
                url: `/books/${id}/edit`,
                type: 'GET',
                success: function ({id, book_name, book_author, book_cover_photo_path}) {
                    // Handle success response here
                    $('#book_name_edit').val(book_name);
                    $('#book_author_edit').val(book_author);
                    $('#current_book_cover_photo_edit').attr('src', `{{ asset('storage') }}/${book_cover_photo_path}`);
                },
                error: function (error) {
                    // Handle error response here
                    console.log(error);
                }
            });
        }
    </script>
    @endpush
</x-app-layout>