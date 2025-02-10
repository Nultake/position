<?php

namespace App\Http\Controllers\Position;

use App\Http\Controllers\PositionController;
use App\Http\Requests\Position\CreateRequest;

class CreateController extends PositionController
{
    public function __invoke(CreateRequest $request)
    {
        // get validated data from request
        $data = $request->validated();

        $createdPosition = $this->positionService->store($data);

        return response()->json([
            "message" => "SUCCESS",
            "position" => $createdPosition->toArray()
        ]);
    }
}
