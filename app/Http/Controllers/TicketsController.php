<?php

namespace App\Http\Controllers;

use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\TicketRequest;



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

    public function store(TicketRequest $request): JsonResponse
    {

        return response()->json($this->ticketService->createTicket($request->validated()), 201);
    }

    public function update(TicketRequest $request, $id): JsonResponse
    {
        
        return response()->json($this->ticketService->updateTicket($id, $request->validated()));
    }

    public function destroy($id): JsonResponse
    {
        return response()->json($this->ticketService->deleteTicket($id));
    }

    // change status ticket to 'in progress'
    public function start($id): JsonResponse
    {
        return response()->json($this->ticketService->updateTicket($id, ['status' => 'in progress']));
    }

    // close ticket (changer son statut à 'closed')
    public function close($id): JsonResponse
    {
        return response()->json($this->ticketService->updateTicket($id, ['status' => 'closed']));
    }

    // diplay tickets (filtr par statut)
    public function openTickets(): JsonResponse
    {
        return response()->json($this->ticketService->getTicketsByStatus('open'));
    }

    // Voir les tickets en cours (filtrer par statut)
    public function inProgressTickets(): JsonResponse
    {
        return response()->json($this->ticketService->getTicketsByStatus('in progress'));
    }

    // Voir les tickets fermés (filtrer par statut)
    public function closedTickets(): JsonResponse
    {
        return response()->json($this->ticketService->getTicketsByStatus('closed'));
    }
}
