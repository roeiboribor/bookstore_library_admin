<?php

namespace App\Imports;

use App\Models\Book;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BooksImport implements ToCollection, WithHeadingRow
{
    use Importable;

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function collection(Collection $rows)
    {
        $validatedData = Validator::make($rows->toArray(), [
            '*.book_name' => 'required|min:1|max:255|unique:books',
            '*.book_author' => 'required|min:1|max:255',
            '*.cover_photo' => 'nullable',
        ], [
            '*.book_name.unique' => 'Book name must be unique on row [:attribute]',
            '*.book_name.required' => 'Missing Book Name on row [:attribute]',
            '*.book_author.required' => 'Missing Book Author on row [:attribute]',
        ])->validateWithBag('importBooks');

        foreach ($validatedData as $item) {
            Book::create([
                'book_name' => $item['book_name'],
                'book_author' => $item['book_author'],
                'book_cover_photo_path' => 'book_covers/' . $item['cover_photo'] ?? null,
            ]);
        }
    }
}
