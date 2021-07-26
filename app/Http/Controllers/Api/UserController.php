<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\IUserService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    private IUserService $userService;

    /**
     * Display a listing of the resource.
     *
     * @param \App\Interfaces\IUserService $userService InterfaceUserService
     */
    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $result = $this->userService->all();
            $response['body'] = $result;
            if(!empty($result['errors'])){
                $response['body'] = $result['errors'];
            }
            $response['status'] = (!empty($result['status']) ? $result['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            $response['status'] = 404;
        }


        return response()->json($response['body'], $response['status']);
    }

    public function store(Request $request)
    {
        try {
            $request->validate($this->rules(), $this->messages());

            $result = $this->userService->store($request->all());
            $response['body'] = $result;
            if(!empty($result['errors'])){
                $response['body'] = $result['errors'];
            }
            $response['status'] = (!empty($result['status']) ? $result['status'] : 201);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();

            if ($ex instanceof ValidationException) {
                $response['body']['errors'] = $ex->errors();
            }
            $response['status'] = 404;
        }

        return response()->json($response['body'], $response['status']);
    }

    public function show($id)
    {
        try {
            $result = $this->userService->show($id);
            $response['body'] = $result;
            if(!empty($result['errors'])){
                $response['body'] = $result['errors'];
            }
            $response['status'] = (!empty($result['status']) ? $result['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            $response['status'] = 404;
        }

        return response()->json($response['body'], $response['status']);
    }

    public function update(Request $request, $id)
    {
        try {
            $sometimes = '';
            if ($request->method() === 'PATCH') {
                $sometimes = '|sometimes';
            }

            $request->validate($this->rules($id, $sometimes), $this->messages());

            $result = $this->userService->update($request->all(), $id);
            $response['body'] = $result;
            if(!empty($result['errors'])){
                $response['body'] = $result['errors'];
            }
            $response['status'] = (!empty($result['status']) ? $result['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            if ($ex instanceof ValidationException) {
                $response['body']['errors'] = $ex->errors();
            }
            $response['status'] = 404;
        }

        return response()->json($response['body'], $response['status']);
    }

    public function destroy($id)
    {
        try {
            $result = $this->userService->destroy($id);
            $response['body'] = $result;
            if(!empty($result['errors'])){
                $response['body'] = $result['errors'];
            }
            $response['status'] = (!empty($result['status']) ? $result['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            $response['status'] = 404;
        }

        return response()->json($response['body'], $response['status']);
    }

    private function rules($id = '', $sometimes = '')
    {
        return [
            'name' => 'required|min:2' . $sometimes,
            'email' => 'required|email|unique:users,email,' . $id . $sometimes,
            'password' => 'required|min:4|max:32' . $sometimes
        ];
    }

    private function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório!',
            'name.min' => 'O nome deve ter, pelo menos, 2 caracteres!',
            'name.max' => 'O nome deve ter, no máximo, 80 caracteres!',

            'email.required' => 'O campo e-mail é obrigatório!',
            'email.email' => 'O campo e-mail está fora do formato esperado!',
            'email.unique' => 'O e-mail informado já está cadastrado!',

            'password.required' => 'O campo senha é obrigatório!',
            'password.min' => 'A senha deve ter, pelo menos, 4 caracteres!',
            'password.max' => 'A senha deve ter, no máximo, 32 caracteres!'
        ];
    }
}
