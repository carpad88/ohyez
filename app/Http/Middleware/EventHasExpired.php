<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class EventHasExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $event = $request->invitation->event;

        $expirationDate = Carbon::parse($event->date->format('Y-m-d').' '.$event->time)->addDays(2);

        if ($expirationDate->isPast()) {
            $request->session()->flush();
            Cookie::queue(Cookie::forget('invitation_authenticated'));

            Notification::make()
                ->title('Evento pasado')
                ->body('La invitación que intentas ver es de un evento que ya pasó.')
                ->success()
                ->send();

            return redirect('/');
        }

        return $next($request);
    }
}
