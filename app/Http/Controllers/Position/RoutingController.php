<?php

namespace App\Http\Controllers\Position;

use App\Http\Controllers\PositionController;
use App\Http\Requests\Position\RoutingRequest;
use App\Models\Position;

class RoutingController extends PositionController
{
    public function __invoke(RoutingRequest $request)
    {
        $latitude = $request->input("latitude");
        $longitude = $request->input("longitude");

        return response()->json([
            "message" => "SUCCESS",
            "positions" => $this->positionService->routing($latitude, $longitude)->map(fn(Position $position) => $position->toArray())->toArray()
        ]);
    }
}
