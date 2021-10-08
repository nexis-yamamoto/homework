<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use Validator;
use App\Http\Validators\SimpleValidator;

class UserValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $validator = $this->app['validator'];
        $validator->resolver(function($translator, $data, $rules, $messages){
            return new SimpleValidator($translator, $data, $rules, $messages);
        });

        Validator::extend('multiple3', function($attirbute, $value, $parameters) {
            return is_numeric($value) && ($value % 3 === 0);
        });
    }
}
