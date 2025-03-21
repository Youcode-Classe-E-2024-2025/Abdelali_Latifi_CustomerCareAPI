<?php

namespace App\Services;

use App\Models\Respenses;
use Illuminate\Support\Facades\Auth;

class ResponseService
{
    public function getResponsesByTicketId($ticketId)
    {
        return Respenses::where('ticket_id', $ticketId)->with('user')->get();
    }

    public function createResponse($ticketId, array $data)
    {
        return Respenses::create([
            'ticket_id' => $ticketId,
            'user_id' => Auth::id(),
            'message' => $data['message'],
        ]);
    }

    public function updateResponse($id, array $data)
    {
        $response = Respenses::findOrFail($id);
        $response->update($data);
        return $response;
    }

    public function deleteResponse($id)
    {
        $response = Respenses::findOrFail($id);
        $response->delete();
        return ['message' => 'Réponse supprimée avec succès'];
    }
}
