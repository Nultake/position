<?php

namespace App\Services;

use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;

class PositionService
{
    /**
     * Create and retrieve position.
     *
     * @param array{name: string, color: string, latitude: float, longitude: float} $data
     * @return Position
     */
    public function store(array $data): Position
    {
        return Position::create($data);
    }

    /**
     * Retrieve all position
     *
     * @return Collection<int, Position>
     */
    public function getAll(): Collection
    {
        return Position::all();
    }

    /**
     * Retrieve the position by id
     *
     * @param string $id
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException<Position>
     * @return Position
     */
    public function getOne(string $id): Position
    {
        return Position::findOrFail($id);
    }

    /**
     * Update and retrieve the position
     *
     * @param string $id
     * @param array $data
     * @return Position
     */
    public function update(string $id, array $data): Position
    {
        $position = $this->getOne($id);

        $position->update($data);

        return $position;
    }

    /**
     * Get closest Positions
     *
     * @param float $latitude
     * @param float $longitude
     * @return Collection<int, Position>
     */
    public function routing(float $latitude, float $longitude): Collection
    {

        return Position::selectRaw(
            "*,
            ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) )
            * cos( radians( longitude ) - radians(?) )
            + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance",
            [$latitude, $longitude, $latitude]
        )
            ->orderBy("distance", "asc") // sorting for closest ones
            ->get();
    }
}
