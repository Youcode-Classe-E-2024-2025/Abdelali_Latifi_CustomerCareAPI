<?php

namespace App\Http\Controllers;

use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RespensesController extends Controller
{
    protected $responseService;

    public function __construct(ResponseService $responseService){

        $this->responseService = $responseService;
    }
    public function index($ticketId): JsonResponse
    {
        return response()->json($this->responseService->getResponsesByTicketId($ticketId));
    }

    public function store(Request $request, $ticketId): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        return response()->json($this->responseService->createResponse($ticketId, $validated), 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        return response()->json($this->responseService->updateResponse($id, $validated));
    }

    public function destroy($id): JsonResponse
    {
        return response()->json($this->responseService->deleteResponse($id));
    }
}
