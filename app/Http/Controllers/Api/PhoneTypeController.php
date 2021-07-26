<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\IPhoneTypeService;
use Illuminate\Http\Request;

class PhoneTypeController extends Controller
{
    private IPhoneTypeService $phoneTypeService;

    public function __construct(IPhoneTypeService $phoneTypeService) {
        $this->phoneTypeService = $phoneTypeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $response['body'] = $this->phoneTypeService->all();
            $response['status'] = (!empty($response['status']) ? $response['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            $response['status'] = 404;
        }


        return response()->json($response['body'], $response['status']);
    }
}
