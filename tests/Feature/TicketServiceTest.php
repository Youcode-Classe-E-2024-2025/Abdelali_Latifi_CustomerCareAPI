<?php

namespace Tests\Feature;

use App\Models\Tickets;
use App\Models\User;
use App\Services\TicketService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $ticketService;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ticketService = new TicketService();
        $this->user = User::factory()->create();
        $this->actingAs($this->user); 
    }

    /** @test */
    public function it_can_get_all_tickets()
    {
        Tickets::factory(5)->create();

        $tickets = $this->ticketService->getAllTickets();

        $this->assertCount(5, $tickets);
    }

    /** @test */
    /** @test */
public function it_can_get_user_tickets()
{
    Tickets::factory(3)->create(['user_id' => $this->user->id]);

    $tickets = $this->ticketService->getUserTickets();

    $this->assertCount(3, $tickets);
}


    /** @test */
    public function it_can_create_a_ticket()
    {
        $data = [
            'subject' => 'Problème de connexion',
            'description' => 'Je ne peux pas me connecter à mon compte.',
            'status' => 'open'
        ];

        $ticket = $this->ticketService->createTicket($data);

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'user_id' => $this->user->id,
            'subject' => 'Problème de connexion'
        ]);
    }

    /** @test */
    public function it_can_update_a_ticket()
    {
        $ticket = Tickets::factory()->create(['user_id' => $this->user->id]);

        $updatedTicket = $this->ticketService->updateTicket($ticket->id, ['status' => 'in progress']);

        $this->assertEquals('in progress', $updatedTicket->status);
        $this->assertDatabaseHas('tickets', ['id' => $ticket->id, 'status' => 'in progress']);
    }

    /** @test */
    public function it_cannot_update_a_ticket_if_not_owner_or_admin()
    {
        $otherUser = User::factory()->create();
        $ticket = Tickets::factory()->create(['user_id' => $otherUser->id]);

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);

        $this->ticketService->updateTicket($ticket->id, ['status' => 'closed']);
    }

    /** @test */
    public function it_can_delete_a_ticket()
    {
        $ticket = Tickets::factory()->create(['user_id' => $this->user->id]);

        $response = $this->ticketService->deleteTicket($ticket->id);

        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
        $this->assertEquals(['message' => 'Ticket supprimé avec succès'], $response);
    }

    /** @test */
    public function it_cannot_delete_a_ticket_if_not_owner_or_admin()
    {
        $otherUser = User::factory()->create();
        $ticket = Tickets::factory()->create(['user_id' => $otherUser->id]);

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);

        $this->ticketService->deleteTicket($ticket->id);
    }

    /** @test */
    public function it_can_get_tickets_by_status()
    {
        Tickets::factory(2)->create(['status' => 'open']);
        Tickets::factory(3)->create(['status' => 'closed']);

        $openTickets = $this->ticketService->getTicketsByStatus('open');
        $closedTickets = $this->ticketService->getTicketsByStatus('closed');

        $this->assertCount(2, $openTickets);
        $this->assertCount(3, $closedTickets);
    }
}
