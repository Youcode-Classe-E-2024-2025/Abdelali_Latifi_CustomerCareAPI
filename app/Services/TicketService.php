<?php

namespace App\Services;

use App\Models\Tickets;
use Illuminate\Support\Facades\Auth;

class TicketService
{
    public function getAllTickets()
    {
        return Tickets::with('user')->get();
    }

    public function getUserTickets()
    {
        return Tickets::where('user_id', Auth::id())->get();
    }

    public function getTicketById($id)
    {
        return Tickets::with('user')->findOrFail($id);
    }

    public function createTicket(array $data)
    {
        return Tickets::create([
            'user_id' => Auth::id(),
            'subject' => $data['subject'],
            'description' => $data['description'],
            'status' => $data['status'] ?? 'open',
        ]);
    }

    public function updateTicket($id, array $data)
    {
        $ticket = Tickets::findOrFail($id);
        $ticket->update($data);
        return $ticket;
    }

    public function deleteTicket($id)
    {
        $ticket = Tickets::findOrFail($id);
        $ticket->delete();
        return ['message' => 'Ticket supprimé avec succès'];
    }
}
