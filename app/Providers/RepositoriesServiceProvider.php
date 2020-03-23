<?php

namespace App\Providers;

use App\Repositories\CartRepository;
use App\Repositories\CartRepositoryInterface;
use App\Repositories\FaqRepository;
use App\Repositories\FaqRepositoryInterface;
use App\Repositories\GoodsRepository;
use App\Repositories\GoodsRepositoryInterface;
use App\Repositories\OptionRepository;
use App\Repositories\OptionRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\QuestionRepository;
use App\Repositories\QuestionRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
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
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(FaqRepositoryInterface::class, FaqRepository::class);
        $this->app->bind(QuestionRepositoryInterface::class, QuestionRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(GoodsRepositoryInterface::class, GoodsRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(OptionRepositoryInterface::class, OptionRepository::class);
    }
}
