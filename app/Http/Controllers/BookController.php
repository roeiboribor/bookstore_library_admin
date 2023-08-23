<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = \App\Models\Book::select([
                'id', 'book_name', 'book_author', 'book_cover_photo_path'
            ])
                ->orderBy('book_name', 'ASC')
                ->get();

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
    public function show($id = null)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
        $data = \App\Models\Book::find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = null)
    {
        dd($request);
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
