<?php

namespace Tests\Feature\Position;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_position_successfully(): void
    {
        $position = Position::factory()->create();

        $updateData = [
            'name' => 'Updated Name',
            'color' => '#00FF00',
            'latitude' => 80,
            'longitude' => 80,
        ];

        $response = $this->postJson("/position/{$position->id}", $updateData);

        // reload model from db
        $position = $position->refresh();

        $this->assertEquals($position->toArray(), ['id' => $position->id, ...$updateData]);

        $response->assertStatus(200)
            ->assertExactJson([
                'message' => 'SUCCESS',
                'position' => [
                    'id' => $position->id,
                    'name' => $position->name,
                    'color' => $position->color,
                    'latitude' => $position->latitude,
                    'longitude' => $position->longitude,
                ],
            ]);
    }

    public function test_update_position_not_found(): void
    {
        $id = Str::uuid();

        $updateData = [
            'name' => 'Updated Name',
            'color' => '#00FF00',
            'latitude' => 80,
            'longitude' => 80,
        ];

        $response = $this->postJson('/positions/' . $id, $updateData);

        $response->assertStatus(404)
            ->assertJson([
                'message' => "The route positions/{$id} could not be found.",
            ]);
    }

    public function test_update_position_with_validation_error(): void
    {
        $position = Position::factory()->create();

        $updateData = [
            'name' => 'X',  // too short (min 3)
            'latitude' => 100,  // out of range (-90 to 90)
            'longitude' => 200, // out of range (-180 to 180)
        ];

        $response = $this->postJson("/position/{$position->id}", $updateData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'latitude', 'longitude']);
    }
}
