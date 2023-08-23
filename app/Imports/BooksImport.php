<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class BooksImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return new Book([
            'book_name'     => $row[0],
            'book_author'    => $row[1],
            'book_cover_photo_path' => $row[2] ?? null,
        ]);
    }
}
