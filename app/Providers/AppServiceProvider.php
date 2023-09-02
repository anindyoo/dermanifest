<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
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
        if (Admin::all()->count() == 0) {
            Admin::create([
                'name_admin' => 'Dermanifest Admin (Main)',
                'email' => env('ADMIN_DEFAULT_EMAIL'),
                'password' => Hash::make(env('ADMIN_DEFAULT_PASSWORD')),
            ]);
        }

        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        // share categories
        $categories = Category::all();
        View::share([
            'global_categories' => $categories,
        ]);
    }
}
