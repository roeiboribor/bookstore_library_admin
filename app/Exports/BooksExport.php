<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BooksExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;
    use RegistersEventListeners;

    public function __construct($data)
    {
        $this->selectedBooks = explode(',', $data);
    }

    public function query()
    {
        return Book::query()->whereIn('id', $this->selectedBooks);
    }

    public function map($applicant): array
    {
        $modelData = $this->modelData($applicant);
        return $modelData;
    }

    public function headings(): array
    {
        $dataHeaders = $this->dataHeaders();
        return $dataHeaders;
    }

    public function modelData($book): array
    {
        return [
            $book->id,
            $book->book_name,
            $book->book_author,
            public_path('storage/') . $book->book_cover_photo_path,
            $book->created_at->format('F d, Y'),
        ];
    }

    public static function dataHeaders(): array
    {
        return [
            'ID',
            'Name',
            'Author',
            'Cover Photo',
            'Created At',
        ];
    }
}
