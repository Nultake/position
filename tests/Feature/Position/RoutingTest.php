<?php

namespace Tests\Feature\Position;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    use RefreshDatabase;

    public function test_routing_positions_successfully(): void
    {

        $searchPoint = [
            'latitude' => 0,
            'longitude' => 0,
        ];

        $nearest = Position::factory()->create([
            'name' => 'Nearest Point',
            'latitude' => 1,
            'longitude' => 1,
        ]);

        $farest = Position::factory()->create([
            'name' => 'Farest Point',
            'latitude' => 90,
            'longitude' => 90,
        ]);

        $response = $this->postJson('/position/routing', $searchPoint);

        $response->assertStatus(200)
            ->assertExactJson([
                'message' => 'SUCCESS',
                'positions' => [
                    [
                        'id' => $nearest->id,
                        'name' => 'Nearest Point',
                        'color' => $nearest->color,
                        'latitude' => 1,
                        'longitude' => 1,
                    ],
                    [
                        'id' => $farest->id,
                        'name' => 'Farest Point',
                        'color' => $farest->color,
                        'latitude' => 90,
                        'longitude' => 90,
                    ]
                ]
            ]);
    }

    public function test_routing_positions_when_no_nearby_positions(): void
    {
        $response = $this->postJson('/position/routing', [
            'latitude' => 0.0,
            'longitude' => 0.0,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'SUCCESS',
                'positions' => [],
            ]);
    }

    public function test_routing_positions_with_validation_error(): void
    {
        $response = $this->postJson('/position/routing', [
            'latitude' => 100,  // out of range
            'longitude' => -190, // out of range
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['latitude', 'longitude']);
    }
}
