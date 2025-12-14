<?php

namespace App\Providers;

use App\Models\Permission;
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

         // نگهبان ورودی
        try{
            foreach(Permission::all() as $permission){
                Gate::define($permission->title, function ($user) use ($permission){
                    return $user->hasPermission($permission);
                });
            }
        }catch(\Exception $e){}

        view()->composer('*',function($view) {
            $view->with('currentUser', \Auth::user());
        });

    }
}
