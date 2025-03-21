<?php

namespace App\Http\Controllers;

use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TicketsController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->ticketService->getAllTickets());
    }

    public function userTickets(): JsonResponse
    {
        return response()->json($this->ticketService->getUserTickets());
    }

    public function show($id): JsonResponse
    {
        return response()->json($this->ticketService->getTicketById($id));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'sometimes|in:open,in progress,closed',
        ]);

        return response()->json($this->ticketService->createTicket($validated), 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'subject' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'status' => 'sometimes|in:open,in progress,closed',
        ]);

        return response()->json($this->ticketService->updateTicket($id, $validated));
    }

    public function destroy($id): JsonResponse
    {
        return response()->json($this->ticketService->deleteTicket($id));
    }
}
