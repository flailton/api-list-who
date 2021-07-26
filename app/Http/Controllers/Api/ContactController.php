<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\IContactService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    private IContactService $contactService;

    /**
     * Display a listing of the resource.
     *
     * @param \App\Interfaces\IContactService $contactService InterfaceContactService
     */
    public function __construct(IContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index()
    {
        try {
            $response['body'] = $this->contactService->all();
            $response['status'] = (!empty($response['status']) ? $response['status'] : 200);
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

            $attributes = $request->all();
            $attributes['user_id'] = session('user')->id;

            $response['body'] = $this->contactService->store($attributes);
            $response['status'] = (!empty($response['status']) ? $response['status'] : 201);
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
            $response['body'] = $this->contactService->show($id);
            $response['status'] = (!empty($response['status']) ? $response['status'] : 200);
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

            $attributes = $request->all();
            $attributes['user_id'] = session('user')->id;

            $response['body'] = $this->contactService->update($attributes, $id);
            $response['status'] = (!empty($response['status']) ? $response['status'] : 200);
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
            $response['body'] = $this->contactService->destroy($id);
            $response['status'] = (!empty($response['status']) ? $response['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            $response['status'] = 404;
        }

        return response()->json($response['body'], $response['status']);
    }

    private function rules($id = '', $sometimes = '')
    {
        return [
            'name' => 'required|min:2|max:80' . $sometimes,
            'email' => 'required|email' . $sometimes
        ];
    }

    private function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório!',
            'name.min' => 'O nome deve ter, pelo menos, 2 caracteres!',
            'name.max' => 'O nome deve ter, no máximo, 80 caracteres!',

            'email.required' => 'O campo e-mail é obrigatório!',
            'email.email' => 'O campo e-mail está fora do formato esperado!'
        ];
    }
}
