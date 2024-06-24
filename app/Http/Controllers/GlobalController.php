<?php

namespace App\Http\Controllers;

use App\Domain\Sidebars\Sidebar;

class GlobalController extends Controller
{
    public function sidebar()
    {
        try {
            return response()->json(Sidebar::build());
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
