<?php
namespace CoreWeb;

use Illuminate\Support\ServiceProvider;

class CoreWebServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->publishes([
            __DIR__.'/Domain' => base_path('app/Domain/'),
            __DIR__.'/Services' => base_path('app/Services/'),
            __DIR__.'/Repositories' => base_path('app/Repositories/'),
            __DIR__.'/Components' => base_path('app/Components/'),
            __DIR__.'/Controllers' => base_path('app/Http/Controllers/'),
            __DIR__.'/config/authapi.php' => config_path('authapi.php'),
            __DIR__.'/routes' => base_path('routes/'),
            __DIR__.'/views' => base_path('resources/views'),
            __DIR__.'/lang/en' => base_path('resources/lang/en/'),
            __DIR__.'/database/migrations' => base_path('/database/migrations/'),
            __DIR__.'/database/seeds' => base_path('/database/seeds/'),
        ]);
        
    }
    
    public function register(){
        
    }
}

