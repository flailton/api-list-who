<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\ILinkTypeService;
use Illuminate\Http\Request;

class LinkTypeController extends Controller
{
    private ILinkTypeService $linkTypeService;

    public function __construct(ILinkTypeService $linkTypeService) {
        $this->linkTypeService = $linkTypeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $response['body'] = $this->linkTypeService->all();
            $response['status'] = (!empty($response['status']) ? $response['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            $response['status'] = 404;
        }


        return response()->json($response['body'], $response['status']);
    }
}
