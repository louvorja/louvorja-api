<?php

namespace App\Http\Controllers;

use App\Helpers\Data;
use App\Helpers\Validations;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function validationRules(Request $request, $id = null)
    {
        return [
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username' . ($id ? ",$id" : ''),
            'email' => 'required|string|email|unique:users,email' . ($id ? ",$id" : ''),
        ];
    }

    private function validationMessages()
    {
        return Validations::validationMessages();
    }


    public function index(Request $request)
    {
        $model = new User;
        $data = $model->select();

        return response()->json(Data::data($data, $request, [$model->getKeyName(), ...$model->getFillable()]));
    }

    public function show($id, Request $request)
    {
        $user = User::find($id);

        $data = (object) [];
        $data->data = $user;

        if (!$user) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $rules = $this->validationRules($request);
        $rules['password'] = 'required|string|min:6';

        $this->validate($request, $rules, $this->validationMessages());

        $inputs = $request->except('is_admin');
        if ($request->filled('password')) {
            $inputs['password'] = Hash::make($request->input('password'));
            $inputs['is_temporary_password'] = true;
        }
        $user = User::create($inputs);

        $data = (object) [];
        $data->data = $user;
        $data->message = 'Registro cadastrado com sucesso!';
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $rules = $this->validationRules($request, $id);
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6';
        }

        $this->validate($request, $rules, $this->validationMessages());

        $user = User::find($id);

        $data = (object) [];
        $data->data = $user;

        if (!$user) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $inputs = $request->except('is_admin');
        if ($request->filled('password')) {
            if ($user->is_admin) {
                return response()->json(['error' => 'A senha do administrador não pode ser alterada por esta rota!'], 400);
            }
            $inputs['password'] = Hash::make($request->input('password'));
            $inputs['is_temporary_password'] = true;
        }
        if ($user->is_admin) {
            unset($inputs['permissions']);
        }
        $user->update($inputs);

        $data->message = 'Registro alterado com sucesso!';
        return response()->json($data);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $data = (object) [];
        $data->data = $user;

        if (!$user) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        if ($user->is_admin) {
            return response()->json(['error' => 'Este usuário não pode ser excluído!'], 400);
        }

        $user->delete();
        return response()->json(['message' => 'Registro excluído com sucesso!']);
    }
}
