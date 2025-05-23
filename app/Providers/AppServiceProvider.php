<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    View::composer('*', function ($view) {
        if (Auth::check()) { 
            $user = Auth::user();
            Log::info('User Type:', ['type' => $user->type]);

            $pendingAppointments = collect();
            $completedAppointments = collect();
            $appointmentCount = 0;
            $completedCount = 0;

            // Handling different user types
            if ($user->type == 1) {
                Log::info('Fetching pending appointments for admin');
                $pendingAppointments = Appointment::where('status', 'pending')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            } elseif ($user->type == 2) {
                Log::info('Fetching pending appointments for doctor:', ['doctor' => $user->name]);
                $pendingAppointments = Appointment::where('status', 'pending')
                    ->where('doctor', $user->name)
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            } elseif ($user->type == 3) {
                Log::info('Fetching completed appointments for cashier');
                $completedAppointments = Appointment::where('status', 'completed')
                    ->whereDate('updated_at', now()->toDateString()) 
                    ->orderBy('updated_at', 'desc')
                    ->take(5)
                    ->get();
            } elseif ($user->type == 0) {
                Log::info('Fetching completed appointments for user');
                $completedAppointments = Appointment::where('status', 'completed')
                    ->where('user_id', $user->id)
                    ->orderBy('updated_at', 'desc')
                    ->take(5)
                    ->get();
            } else {
                Log::info('No pending or completed appointments for this user type.');
            }

            // Counting the appointments
            $appointmentCount = $pendingAppointments->count();
            $completedCount = $completedAppointments->count();

            Log::info('Total Pending Appointments:', ['count' => $appointmentCount]);
            Log::info('Total Completed Appointments Today:', ['count' => $completedCount]);

            // Pass data to the view
            $view->with(compact('pendingAppointments', 'appointmentCount', 'completedAppointments', 'completedCount'));
        }
    });
}

}
