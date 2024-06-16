<?php

namespace App\Http\Controllers;

use App\Domain\Services\OAuthService;
use Illuminate\Http\Request;

class OAuthController extends Controller
{
    public function __construct(
        protected OAuthService $oAuthService,
    ) {
    }

    public function login(Request $request)
    {
        return $this->oAuthService->authorize($request);
    }

    public function callback(Request $request)
    {
        try {
            $this->oAuthService->callback($request);
            return to_route('home');
        } catch (\Throwable $th) {
            return to_route('login')->with('error', $th->getMessage());
        }
    }
}
