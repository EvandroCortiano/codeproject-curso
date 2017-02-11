<?php

namespace CodeProject\Providers;

use Illuminate\Support\ServiceProvider;

class CodeProjectRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    	//Todas as vezes que requisitarmos o ClientRepository queremos requisitar o CLientRepositoryEloquent
        $this->app->bind(
        		\CodeProject\Repositories\ClientRepository::class, 
        		\CodeProject\Repositories\ClientRepositoryEloquent::class);
        
        $this->app->bind(
        		\CodeProject\Repositories\ProjectRepository::class,
        		\CodeProject\Repositories\ProjectRepositoryEloquent::class);
        
        $this->app->bind(
        		\CodeProject\Repositories\ProjectNoteRepository::class,
        		\CodeProject\Repositories\ProjectNoteRepositoryEloquent::class);
    }
}
