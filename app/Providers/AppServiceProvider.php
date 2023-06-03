<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Blade;

use App\Helpers\UserHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // blade directive 'student'
        Blade::if('student', function () {
            return UserHelper::isStudent(auth()->user());
        });
        // // blade directive 'teacher'
        Blade::if('teacher', function () {
            return UserHelper::isTeacher(auth()->user());
        });
    }
}
