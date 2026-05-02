<?php

    namespace App\Providers;

    use Illuminate\Support\ServiceProvider;
    use Illuminate\Http\Request;
    use Illuminate\Auth\Middleware\Authenticate;
    use Illuminate\Auth\Middleware\RedirectIfAuthenticated;


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
            Authenticate::redirectUsing(function (Request $request) {

            });

            RedirectIfAuthenticated::redirectUsing(function (Request $request) {

            });

        }
    }
