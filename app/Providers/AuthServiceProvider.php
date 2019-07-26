<?php

namespace App\Providers;

use App\Question;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Post' => 'App\Policies\PostPolicy',
        'App\Question' => 'App\Policies\QuestionPolicy',
        'App\Talk' => 'App\Policies\TalkPolicy',
        'App\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Gate::define('comment', function ($user, $question) {
            return $user->id == $question->user_id;
        });

        Gate::define('store-comment', function ($user, $talk) {
            return $user->id == $talk->user_id && $talk->question->status === Question::status['analyzing'];
        });

        Gate::define('accept', function ($user, $post) {
            return $user->id === $post->talk->receiver_id && $post->talk->question->status === Question::status['analyzing'];
        });

        Gate::define('refused', function ($user, $post) {
            return $user->id === $post->talk->receiver_id && $post->talk->question->status !== Question::status['payment'];
        });

        Gate::define('status', function ($user, $post) {
            return $user->id === $post->talk->receiver_id && $post->talk->question->status === Question::status['warranty'];
        });

        Gate::define('message', function ($user, $post) {
            return ($user->id === $post->talk->user_id || $user->id === $post->talk->receiver_id) && $post->talk->status !== \App\Talk::status['inactive'];
        });

        Gate::define('payment', function ($user, $post) {
            return $user->id === $post->talk->receiver_id && $post->status !== \App\Post::status['refused'];
        });
    }
}
