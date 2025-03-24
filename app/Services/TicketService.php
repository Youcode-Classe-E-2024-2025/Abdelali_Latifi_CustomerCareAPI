<?php

namespace App\Services;

use App\Models\Tickets;
use Illuminate\Support\Facades\Auth;

class TicketService
{
    /**
     * Récupérer tous les tickets (admin ou support)
     */
    public function getAllTickets()
    {
        return Tickets::with('user')->get();
    }

    /**
     * Récupérer les tickets de l'utilisateur connecté
     */
    public function getUserTickets()
{
    return Tickets::where('user_id', Auth::id())->get();
}

    /**
     * Récupérer un ticket par son ID
     */
    public function getTicketById($id)
    {
        return Tickets::with('user')->findOrFail($id);
    }

    /**
     * Créer un nouveau ticket
     */
    public function createTicket(array $data)
    {
        return Tickets::create([
            'user_id' => Auth::id(),
            'subject' => $data['subject'],
            'description' => $data['description'],
            'status' => $data['status'] ?? 'open',  
        ]);
    }

    /**
     * Mettre à jour un ticket (changer le statut ou modifier les détails)
     */
    public function updateTicket($id, array $data)
    {
        $ticket = Tickets::findOrFail($id);

        if ($ticket->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à modifier ce ticket.');
        }

        $ticket->update($data);

        return $ticket;
    }

    /**
     * Supprimer un ticket (en général réservé aux admins)
     */
    public function deleteTicket($id)
    {
        $ticket = Tickets::findOrFail($id);

        // Vérifie si l'utilisateur est le propriétaire du ticket ou un admin
        if ($ticket->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer ce ticket.');
        }

        $ticket->delete();

        return ['message' => 'Ticket supprimé avec succès'];
    }

    /**
     * Récupérer les tickets filtrés par statut
     */
    public function getTicketsByStatus($status)
    {
        return Tickets::where('status', $status)->get();
    }

    /**
     * Démarrer un ticket (changer son statut à "in progress")
     */
    public function startTicket($id)
    {
        return $this->updateTicket($id, ['status' => 'in progress']);
    }

    /**
     * Fermer un ticket (changer son statut à "closed")
     */
    public function closeTicket($id)
    {
        return $this->updateTicket($id, ['status' => 'closed']);
    }
}
