<?php

namespace App\Http\Controllers;

use App\DataTables\BooksDataTable;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, BooksDataTable $dataTable)
    {
        if ($request->ajax()) {
            $data = \App\Models\Book::select(['book_name', 'author', 'book_cover_photo_path'])->get();

            return DataTables::of($data)->make(true);
        }

        return view('books.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bookCoverPhotoPath = null;

        // Validate the Request
        $validatedRequest = $request->validateWithBag('bookCreation', [
            'book_name' => 'required|min:2|max:255|unique:books',
            'book_author' => 'required|min:2|max:255',
            'book_cover_photo' => 'required|image|mimes:jpeg,png,jpg|max:4048',
        ]);

        // Save Book Cover Photo
        if ($request->hasFile('book_cover_photo')) {
            $bookCoverPhotoPath = $request->file('book_cover_photo')->store('book_covers', 'public');
        }

        $book = \App\Models\Book::create([
            ...collect($validatedRequest)->except('book_cover_photo'),
            'book_cover_photo_path' => $bookCoverPhotoPath
        ]);

        $book && session()->flash('success', 'Book has been added successfully!');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
