<?php

namespace App\Providers;

use App\Interfaces\ProductInterface;
use App\Interfaces\TransactionInterface;
use App\Repositories\ProductInterfaceRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(ProductInterface::class, ProductInterfaceRepository::class);
        $this->app->bind(TransactionInterface::class, TransactionRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
