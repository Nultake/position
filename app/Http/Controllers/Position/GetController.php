<?php

namespace App\Http\Controllers\Position;

use App\Http\Controllers\PositionController;

class GetController extends PositionController
{
    public function __invoke(string $id)
    {
        return response()->json([
            "message"  => "SUCCESS",
            "position" => $this->positionService->getOne($id)->toArray()
        ]);
    }
}
