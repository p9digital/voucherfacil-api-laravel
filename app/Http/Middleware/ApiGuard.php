<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ApiGuard {
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string|null  $guard
   * @return mixed
   */
  public function handle($request, Closure $next) {
    $token = $request->bearerToken();
    if ($token && $token !== '') {
      $user = User::where('token', $token)->first();
      if ($user) {
        Auth::login($user);
        return $next($request);
      }
    }
    return response()->json(collect(['error' => 'Unauthorized']), 401);
  }
}
