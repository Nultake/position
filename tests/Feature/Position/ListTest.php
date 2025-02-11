<?php

namespace Tests\Feature\Position;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_positions_successfully(): void
    {
        Position::factory()->count(3)->create();

        $response = $this->getJson('/position');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'SUCCESS',
            ])
            ->assertExactJsonStructure([
                'message',
                'positions' => [
                    '*' => [
                        'id',
                        'name',
                        'color',
                        'latitude',
                        'longitude'
                    ]
                ]
            ])
            ->assertJsonCount(3, 'positions');
    }

    public function test_list_positions_when_empty(): void
    {
        $response = $this->getJson('/position');

        $response->assertStatus(200)
            ->assertExactJson([
                'message' => 'SUCCESS',
                'positions' => [],
            ]);
    }
}
