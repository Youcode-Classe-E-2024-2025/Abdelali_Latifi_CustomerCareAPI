<?php

namespace App\Http\Controllers;

use App\Services\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Réponses",
 *     description="Gestion des réponses aux tickets"
 * )
 */
class RespensesController extends Controller
{
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    /**
     * @OA\Get(
     *     path="/api/tickets/{ticketId}/responses",
     *     summary="Liste toutes les réponses d'un ticket",
     *     tags={"Réponses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="ticketId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Liste des réponses"),
     *     @OA\Response(response=404, description="Ticket non trouvé"),
     *     @OA\Response(response=401, description="Non authentifié")
     * )
     */
    public function index($ticketId): JsonResponse
    {
        return response()->json($this->responseService->getResponsesByTicketId($ticketId));
    }

    /**
     * @OA\Post(
     *     path="/api/tickets/{ticketId}/responses",
     *     summary="Créer une réponse pour un ticket",
     *     tags={"Réponses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="ticketId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"message"},
     *             @OA\Property(property="message", type="string", example="Merci pour votre patience, nous travaillons sur votre problème.")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Réponse créée avec succès"),
     *     @OA\Response(response=400, description="Données invalides"),
     *     @OA\Response(response=401, description="Non authentifié"),
     *     @OA\Response(response=403, description="Accès interdit")
     * )
     */
    public function store(Request $request, $ticketId): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        return response()->json($this->responseService->createResponse($ticketId, $validated), 201);
    }

    /**
     * @OA\Put(
     *     path="/api/responses/{id}",
     *     summary="Mettre à jour une réponse",
     *     tags={"Réponses"},
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
     *             required={"message"},
     *             @OA\Property(property="message", type="string", example="Mise à jour de la réponse précédente.")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Réponse mise à jour"),
     *     @OA\Response(response=404, description="Réponse non trouvée"),
     *     @OA\Response(response=401, description="Non authentifié"),
     *     @OA\Response(response=403, description="Accès interdit")
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        return response()->json($this->responseService->updateResponse($id, $validated));
    }

    /**
     * @OA\Delete(
     *     path="/api/responses/{id}",
     *     summary="Supprimer une réponse",
     *     tags={"Réponses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Réponse supprimée"),
     *     @OA\Response(response=404, description="Réponse non trouvée"),
     *     @OA\Response(response=401, description="Non authentifié"),
     *     @OA\Response(response=403, description="Accès interdit")
     * )
     */
    public function destroy($id): JsonResponse
    {
        return response()->json($this->responseService->deleteResponse($id));
    }
}
