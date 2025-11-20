<?php

namespace App\Providers;

use App\Models\CadreEventParticipant;
use App\Observers\CadreEventParticipantObserver;
use App\Models\Member;
use App\Observers\MemberObserver;
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
        CadreEventParticipant::observe(CadreEventParticipantObserver::class);
        Member::observe(MemberObserver::class);
    }
}
