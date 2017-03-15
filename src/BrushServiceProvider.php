<?php
namespace GGuney\Brush;
use Illuminate\Support\ServiceProvider;
class BrushServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(){
        $this->mergeConfigFrom(
            __DIR__.'/Publish/config/brush.php', 'brush'
        );
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/Publish/config/brush.php' => config_path('brush.php'),
        ]);
    }
    
}
