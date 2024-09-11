<?php

namespace App\Http\Controllers;

use App\Helpers\Data;
use App\Helpers\Validations;
use App\Models\CategoryAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryAlbumController extends Controller
{
    public function validationRules(Request $request, $id = null)
    {
        return [
            'id_category' => 'required',
            'id_album' => 'required|unique:categories_albums,id_album,' . ($id ? $id : 'NULL') . ',id_category_album,id_category,' . $request->input('id_category'),
            'id_language' => 'required|string|exists:languages,id_language',
        ];
    }

    private function validationMessages()
    {
        return Validations::validationMessages();
    }

    public function index(Request $request)
    {
        $model = new CategoryAlbum;
        $fields = [
            'categories_albums.id_category_album',
            'categories_albums.id_category',
            DB::raw('categories.name as category_name'),
            'categories_albums.id_album',
            DB::raw('albums.name as album_name'),
            'categories_albums.name',
            'categories_albums.order',
            'categories_albums.id_language',
        ];
        $data = $model->select($fields)
            ->leftJoin('categories', 'categories_albums.id_category', 'categories.id_category')
            ->leftJoin('albums', 'categories_albums.id_album', 'albums.id_album');
        if ($request->id_language) {
            $data->where('categories_albums.id_language', $request->id_language);
        }
        return response()->json(Data::data($data, $request, $fields));
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules($request), $this->validationMessages());

        $inputs = $request->all();
        if (!$request->filled('order')) {
            $inputs['order'] = 0;
        }
        if (!$request->filled('name')) {
            $inputs['name'] = '';
        }
        $category_album = CategoryAlbum::create($inputs);

        $data = (object) [];
        $data->data = $category_album;
        $data->message = 'Registro cadastrado com sucesso!';
        return response()->json($data, 201);
    }

    public function show($id, Request $request)
    {
        $category_album = CategoryAlbum::with(['category', 'album'])->find($id);

        $data = (object) [];
        $data->data = $category_album;

        if (!$category_album) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->validationRules($request, $id), $this->validationMessages());

        $category_album = CategoryAlbum::find($id);

        $data = (object) [];
        $data->data = $category_album;

        if (!$category_album) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $category_album->update($request->all());

        $data->message = 'Registro alterado com sucesso!';
        return response()->json($data);
    }

    public function destroy($id)
    {
        $category_album = CategoryAlbum::find($id);

        $data = (object) [];
        $data->data = $category_album;

        if (!$category_album) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $category_album->delete();
        return response()->json(['message' => 'Registro excluído com sucesso!']);
    }
}
