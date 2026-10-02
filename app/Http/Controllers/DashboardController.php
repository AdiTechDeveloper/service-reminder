<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        return view('dashboard', [
            'total'    => $user->clientServices()->count(),
            'expiring' => $user->clientServices()->expiringWithin(10)->count(),
            'expired'  => $user->clientServices()->whereDate('expiry_date', '<', today())->count(),
            'upcoming' => $user->clientServices()->with(['client', 'serviceType'])
                ->whereDate('expiry_date', '<=', today()->addDays(30))
                ->orderBy('expiry_date')->limit(15)->get(),
        ]);
    }
}
