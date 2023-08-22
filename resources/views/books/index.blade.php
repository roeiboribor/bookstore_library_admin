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
                    <div class="text-center">
                        <table id="books-table" class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th>Book Name</th>
                                    <th>Author</th>
                                    <th>Book Cover</th>
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
                    <x-input-label for="book_name" :value="__('Book Name')" />
                    <x-text-input id="book_name" name="book_name" type="text" class="mt-1 block w-full"
                        :value="old('book_name')" placeholder="Enter Book Name..." required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->bookCreation->get('book_name')" />
                </div>

                <div class="col-span-12">
                    <x-input-label for="book_author" :value="__('Book Author')" />
                    <x-text-input id="book_author" name="book_author" type="text" class="mt-1 block w-full"
                        :value="old('book_author')" placeholder="Enter Book Author..." required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->bookCreation->get('book_author')" />
                </div>

                <div class="col-span-12">
                    <x-input-label for="book_cover_photo" :value="__('Book Cover Photo')" />
                    <x-text-input id="book_cover_photo" name="book_cover_photo" type="file"
                        class="mt-1 block w-full shadow-none" />
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

    @push('styles')
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    @endpush

    @push('scripts')
    <!-- DataTables JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Bootstrap 4 Integration -->
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

    <!-- DataTables Responsive Integration -->
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var flashMessage = document.getElementById('flash-message');
            
            setTimeout(function() {
                flashMessage.style.opacity = '0';
            }, 2000); // 2000 milliseconds (2 seconds) is the duration of the fade-out effect
        });
    </script>
    @endpush
</x-app-layout>