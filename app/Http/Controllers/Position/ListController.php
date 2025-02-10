<?php

namespace App\Http\Controllers\Position;

use App\Http\Controllers\PositionController;
use App\Models\Position;

class ListController extends PositionController
{
    public function __invoke()
    {
        return response()->json([
            "message" => "SUCCESS",
            "positions" => $this->positionService->getAll()->map(fn(Position $position) => $position->toArray())->toArray()
        ]);
    }
}
