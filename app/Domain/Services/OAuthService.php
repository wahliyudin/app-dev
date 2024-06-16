<?php

namespace App\Domain\Services;

use App\Domain\Repositories\OAuthRepository;
use App\Domain\Repositories\UserRepository;
use App\Domain\API\HCIS\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use InvalidArgumentException;

class OAuthService
{
    public function __construct(
        protected OAuthRepository $oAuthRepository,
        protected UserService $userService,
        protected UserRepository $userRepository,
    ) {
    }

    private function urlAuthorize(string $query)
    {
        return config('urls.hcis') . "oauth/authorize?$query";
    }

    private function urlCallback()
    {
        return config('urls.hcis') . "oauth/token";
    }

    public function authorize(Request $request)
    {
        $request->session()->put("state", $state = Str::random(40));
        $query = http_build_query([
            'client_id' => config('sso.client_id'),
            'redirect_uri' => route('sso.callback'),
            'response_type' => 'code',
            'state' => $state,
            'prompt' => 'consent',
        ]);
        return redirect($this->urlAuthorize($query));
    }

    public function callback(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $state = $request->session()->pull('state');
            throw_unless(strlen($state) > 0 && $state == $request->state, InvalidArgumentException::class);
            $response = Http::withoutVerifying()->asForm()->post(
                $this->urlCallback(),
                [
                    'grant_type' => 'authorization_code',
                    'client_id' => config('sso.client_id'),
                    'client_secret' => config('sso.client_secret'),
                    'redirect_uri' => route('sso.callback'),
                    'code' => $request->code
                ]
            );
            $response = $response->json();
            if ($response == null) {
                return to_route('login')->with('error', 'OAuth Server Error');
            }
            if (isset($response['error'])) {
                return to_route('login')->with('error', $response['message']);
            }
            $res = $this->userService->first($response['access_token']);
            if (!isset($res['data'])) {
                throw new \Exception('User not found');
            }
            $user = $this->userRepository->store(isset($res['data']) ? $res['data'] : null);
            if (!$user) {
                throw new \Exception('Failed to save user');
            }
            $oAuthToken = $this->oAuthRepository->store($response, $user->getKey());
            if (!$oAuthToken) {
                throw new \Exception('Failed to save oauth token');
            }
            Auth::login($user);
            return $user;
        });
    }

    public function logout()
    {
        $oAuthToken = $this->oAuthRepository->findByUserId(auth()->user()->id);
        if ($oAuthToken) {
            $response = Http::withoutVerifying()->withHeaders([
                "Accept" => "application/json",
                "Authorization" => "Bearer " . $oAuthToken->access_token
            ])->get(config('urls.hcis') . 'api/logout');
            $oAuthToken->delete();
        }
    }
}
