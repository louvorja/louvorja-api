<?php

namespace App\Http\Controllers;

use App\Models\CategoryAlbum;
use Illuminate\Http\Request;

class CategoryAlbumController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        return response()->json(
            CategoryAlbum::where('id_language', $request->id_language)->paginate($request->limit)
        );
    }

    public function create(Request $request)
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(CategoryAlbum $category_album)
    {
        //
    }

    public function edit(CategoryAlbum $category_album)
    {
        //
    }

    public function update(Request $request, CategoryAlbum $category_album)
    {
        //
    }

    public function destroy(CategoryAlbum $category_album)
    {
        //
    }
}
