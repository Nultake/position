<?php

namespace Tests\Feature\Position;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Position;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_position_successfully(): void
    {
        $data = [
            'name' => 'Test Position',
            'color' => '#FF5733',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
        ];

        $response = $this->postJson('/position', $data);

        $createdPosition = Position::query()->find($response->json('position.id'));

        $this->assertModelExists($createdPosition);

        $response->assertStatus(200)
            ->assertExactJson([
                'message' => 'SUCCESS',
                'position' => [
                    'id' => $createdPosition->id,
                    ...$data
                ],
            ]);
    }

    public function test_create_position_with_validation_error(): void
    {
        $data = [
            'name' => 'X',  // too short (min 3)
            'color' => '',  // required
            'latitude' => 100,  // out of range (-90 to 90)
            'longitude' => 200, // out of range (-180 to 180)
        ];

        $response = $this->postJson('/position', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'color', 'latitude', 'longitude']);
    }
}
