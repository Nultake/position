<?php

namespace App\Http\Controllers;

use App\Services\PositionService;

abstract class PositionController extends Controller
{
    public function __construct(
        protected PositionService $positionService
    ) {}
}
