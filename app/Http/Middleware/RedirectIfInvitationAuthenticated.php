<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfInvitationAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            $request->session()->has('invitation_code') &&
            Cookie::get('invitation_authenticated') &&
            $request->session()->get('invitation_code') === $request->invitation->uuid
        ) {
            return redirect()->route('invitation.view', [
                'invitation' => $request->invitation->uuid,
            ]);
        }

        return $next($request);
    }
}
