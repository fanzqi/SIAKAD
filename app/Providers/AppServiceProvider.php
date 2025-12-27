<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Notification;
use App\Observers\NotificationObserver;
use Illuminate\Support\Facades\View;
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
            $notifications = $user->notifications()
                ->wherePivot('is_read', 0)
                ->orderByPivot('created_at', 'desc')
                ->limit(5)
                ->get();
            $count = $notifications->count();
        } else {
            $notifications = collect([]);
            $count = 0;
        }
        $view->with(compact('notifications', 'count'));
    });
}
}