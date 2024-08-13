<?php

namespace App\Domain\Services;

use App\Domain\Gateway\Services\UserService;
use App\Domain\Repositories\OAuthRepository;
use App\Domain\Repositories\UserRepository;
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
    ) {}

    private function url()
    {
        return rtrim(config('sso.client_url'), '/');
    }

    private function urlAuthorize(string $query)
    {
        return $this->url() . "/oauth/authorize?$query";
    }

    private function urlCallback()
    {
        return $this->url() . "/oauth/token";
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
            'error' => $request->session()->get('error'),
            'warning' => $request->session()->get('warning'),
        ]);
        return redirect($this->urlAuthorize($query));
    }

    public function callback(Request $request)
    {
        try {
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
                    throw new \Exception('OAuth Server Error');
                }
                if (isset($response['error'])) {
                    throw new \Exception($response['message']);
                }
                $res = $this->userService->currentUser($response['access_token']);
                if (!isset($res['nik'])) {
                    throw new \Exception('Pastikan internetmu bagus', 422);
                }
                $user = $this->userRepository->store(isset($res) ? $res : null);
                if (!$user) {
                    throw new \Exception('Failed to save user');
                }
                $oAuthToken = $this->oAuthRepository->store($response, $user->getKey());
                if (!$oAuthToken) {
                    throw new \Exception('Failed to save oauth token');
                }
                if (!$user->hasPermission('dashboard_dashboard_read')) {
                    $user->givePermission('dashboard_dashboard_read');
                }
                Auth::login($user);
                return $user;
            });
        } catch (\Throwable $th) {
            if ($th->getCode() != 500) {
                $request->session()->put('warning', $th->getMessage());
            } else {
                $request->session()->put('error', $th->getMessage());
            }
            return to_route('login')->setSession($request->session());
        }
    }

    public function logout()
    {
        $oAuthToken = $this->oAuthRepository->findByUserId(auth()->user()->id);
        if ($oAuthToken) {
            $response = Http::withoutVerifying()->withHeaders([
                "Accept" => "application/json",
                "Authorization" => "Bearer " . $oAuthToken->access_token
            ])->get($this->url() . '/api/logout');
            $oAuthToken->delete();
        }
    }
}
