<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Repositories\AnswerRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\QuestionRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\QuestionnaireRepository;
use App\Interfaces\User\UserRepositoryInterface;
use App\Repositories\UserAnswerRankingRepository;
use App\Interfaces\Answer\AnswerRepositoryInterface;
use App\Interfaces\Question\QuestionRepositoryInterface;
use App\Interfaces\Questionnaire\QuestionnaireRepositoryInterface;
use App\Interfaces\UserAnswerRanking\UserAnswerRankingRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(QuestionnaireRepositoryInterface::class, QuestionnaireRepository::class);
        $this->app->bind(QuestionRepositoryInterface::class, QuestionRepository::class);
        $this->app->bind(AnswerRepositoryInterface::class, AnswerRepository::class);
        $this->app->bind(UserAnswerRankingRepositoryInterface::class, UserAnswerRankingRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Builder::macro('whereLike', function ($field, $string) {
            return $string ? $this->where($field, 'like', '%' . $string . '%') : $this;
        });

        Builder::macro('orWhereLike', function ($field, $string) {
            return $string ? $this->orWhere($field, 'like', '%' . $string . '%') : $this;
        });
    }
}
