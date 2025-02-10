<?php

namespace App\Http\Controllers\Position;

use App\Http\Controllers\PositionController;
use App\Http\Requests\Position\UpdateRequest;

class UpdateController extends PositionController
{
    public function __invoke(UpdateRequest $request, string $id)
    {
        // get validated data from request
        $data = $request->validated();

        $updatedPosition = $this->positionService->update($id, $data);

        return response()->json([
            "message" => "SUCCESS",
            "position" => $updatedPosition->toArray()
        ]);
    }
}
