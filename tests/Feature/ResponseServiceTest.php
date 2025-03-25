<?php

namespace Tests\Feature;

use App\Models\Respenses;
use App\Models\Tickets; 
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResponseServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $service;
    protected $user;
    protected $ticket;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ResponseService();
        $this->user = User::factory()->create();
        $this->ticket = Tickets::factory()->create(); 
       }

    public function test_get_responses_by_ticket_id()
    {
        $response = Respenses::factory()->create(['ticket_id' => $this->ticket->id]);

        $responses = $this->service->getResponsesByTicketId($this->ticket->id);

        $this->assertCount(1, $responses);
        $this->assertEquals($response->id, $responses->first()->id);
    }

    public function test_create_response()
    {
        $this->actingAs($this->user);
        $data = ['message' => 'Test message'];

        $response = $this->service->createResponse($this->ticket->id, $data);

        $this->assertDatabaseHas('respenses', [
            'ticket_id' => $this->ticket->id,
            'user_id' => $this->user->id,
            'message' => 'Test message',
        ]);
    }

    public function test_update_response()
    {
        $response = Respenses::factory()->create(['message' => 'Old message', 'ticket_id' => $this->ticket->id]);

        $updatedResponse = $this->service->updateResponse($response->id, ['message' => 'New message']);

        $this->assertEquals('New message', $updatedResponse->message);
        $this->assertDatabaseHas('respenses', ['message' => 'New message']);
    }

    public function test_delete_response()
    {
        $response = Respenses::factory()->create(['ticket_id' => $this->ticket->id]);

        $this->service->deleteResponse($response->id);

        $this->assertDatabaseMissing('respenses', ['id' => $response->id]);
    }
}
