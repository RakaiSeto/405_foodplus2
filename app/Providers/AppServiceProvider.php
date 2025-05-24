<?php

namespace App\Providers;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        //
        Gate::define("insert-donation", function (User $user){
            return $user->role === "penyedia";
        });

        Gate::define("update-donation", function (User $user, Donation $donation) {
            return $user->role === "penyedia" && $user->id === $donation->user_id;
        });

    Gate::define("subscription", function (User $user, User $userToSubscribe) {
            $isAlreadySubscribedToResto = $user->subscriptions()->where("donor_id", $userToSubscribe->id)->exists();
            abort_if(!!$isAlreadySubscribedToResto, 400, "Already Subscribed to this resto");
            return $user->id !== $userToSubscribe->id && $user->role === "penerima" && $userToSubscribe->role === "penyedia";
        });
    }
}
