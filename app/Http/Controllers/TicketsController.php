<?php

namespace App\Http\Controllers;

use App\Services\TicketService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\TicketRequest;

/**
 * @OA\Tag(
 *     name="Tickets",
 *     description="Gestion des tickets"
 * )
 */
class TicketsController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * @OA\Get(
     *     path="/api/tickets",
     *     summary="Liste tous les tickets",
     *     tags={"Tickets"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Liste des tickets"),
     *     @OA\Response(response=401, description="Non authentifié"),
     *     @OA\Response(response=403, description="Accès interdit")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->ticketService->getAllTickets());
    }

    /**
     * @OA\Post(
     *     path="/api/tickets",
     *     summary="Créer un nouveau ticket",
     *     tags={"Tickets"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"subject", "description"},
     *             @OA\Property(property="subject", type="string", example="Problème de connexion"),
     *             @OA\Property(property="description", type="string", example="Je n'arrive pas à me connecter"),
     *             @OA\Property(property="status", type="string", enum={"open", "in progress", "closed"}, example="open")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Ticket créé avec succès"),
     *     @OA\Response(response=400, description="Données invalides"),
     *     @OA\Response(response=401, description="Non authentifié"),
     *     @OA\Response(response=403, description="Accès interdit")
     * )
     */
    public function store(TicketRequest $request): JsonResponse
    {
        return response()->json($this->ticketService->createTicket($request->validated()), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/tickets/{id}",
     *     summary="Obtenir un ticket spécifique",
     *     tags={"Tickets"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Détails du ticket"),
     *     @OA\Response(response=404, description="Ticket non trouvé"),
     *     @OA\Response(response=401, description="Non authentifié"),
     *     @OA\Response(response=403, description="Accès interdit")
     * )
     */
    public function show($id): JsonResponse
    {
        return response()->json($this->ticketService->getTicketById($id));
    }

    /**
     * @OA\Put(
     *     path="/api/tickets/{id}",
     *     summary="Mettre à jour un ticket",
     *     tags={"Tickets"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="subject", type="string", example="Mise à jour du problème"),
     *             @OA\Property(property="description", type="string", example="Le problème persiste"),
     *             @OA\Property(property="status", type="string", enum={"open", "in progress", "closed"}, example="in progress")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Ticket mis à jour"),
     *     @OA\Response(response=404, description="Ticket non trouvé"),
     *     @OA\Response(response=401, description="Non authentifié"),
     *     @OA\Response(response=403, description="Accès interdit")
     * )
     */
    public function update(TicketRequest $request, $id): JsonResponse
    {
        return response()->json($this->ticketService->updateTicket($id, $request->validated()));
    }

    /**
     * @OA\Delete(
     *     path="/api/tickets/{id}",
     *     summary="Supprimer un ticket",
     *     tags={"Tickets"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Ticket supprimé"),
     *     @OA\Response(response=404, description="Ticket non trouvé"),
     *     @OA\Response(response=401, description="Non authentifié"),
     *     @OA\Response(response=403, description="Accès interdit")
     * )
     */
    public function destroy($id): JsonResponse
    {
        return response()->json($this->ticketService->deleteTicket($id));
    }
}
