<?php

namespace App\Http\Controllers;

use App\Helpers\Data;
use App\Helpers\Validations;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function validationRules(Request $request, $id = null)
    {
        return [
            'name' => 'required|string',
            'slug' => 'required|string|unique:categories,slug,' . ($id ? $id : 'NULL') . ',id_category,id_language,' . $request->input('id_language'),
            'id_language' => 'required|string|exists:languages,id_language',
        ];
    }

    private function validationMessages()
    {
        return Validations::validationMessages();
    }

    public function index(Request $request)
    {
        $model = new Category;
        $data = $model->select();
        if ($request->id_language) {
            $data->where('id_language', $request->id_language);
        }
        return response()->json(Data::data($data, $request, [$model->getKeyName(), ...$model->getFillable()]));
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules($request), $this->validationMessages());

        $inputs = $request->all();
        if (!$request->filled('order')) {
            $inputs['order'] = 0;
        }
        $category = Category::create($inputs);

        $data = (object) [];
        $data->data = $category;
        $data->message = 'Registro cadastrado com sucesso!';
        return response()->json($data, 201);
    }

    public function show($id, Request $request)
    {
        $category = Category::find($id);

        $data = (object) [];
        $data->data = $category;

        if (!$category) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->validationRules($request, $id), $this->validationMessages());

        $category = Category::find($id);

        $data = (object) [];
        $data->data = $category;

        if (!$category) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $category->update($request->all());

        $data->message = 'Registro alterado com sucesso!';
        return response()->json($data);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        $data = (object) [];
        $data->data = $category;

        if (!$category) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'Registro excluído com sucesso!']);
    }
}
