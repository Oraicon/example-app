<?php

namespace App\Providers;

use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\TransactionRepositoryInterface;
use App\Repositories\ProductRepository;
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
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
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
