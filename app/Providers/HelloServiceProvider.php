<?php

namespace App\Providers;

use App\Http\Validators\HelloValidator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class HelloServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $validator = $this->app['validator']; # バリデータが保存されている
        # resolverメソッドで、リゾルブ(バリデーションの処理を行う)の処理を設定できる
        $validator->resolver(function($translator, $data, $rules, $messages) {
            return new HelloValidator($translator, $data, $rules, $messages);
        });
    }
}
