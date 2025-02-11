<?php

namespace Tests\Feature\Position;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class GetTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_position_successfully(): void
    {
        $position = Position::factory()->create();

        $response = $this->getJson("/position/{$position->id}");

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

    public function test_get_position_not_found(): void
    {
        $id = Str::uuid();

        $response = $this->getJson('/position/' . $id);

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'No query results for model [App\\Models\\Position] ' . $id,
            ]);
    }
}
