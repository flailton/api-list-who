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
            $result = $this->linkTypeService->all();
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
}
