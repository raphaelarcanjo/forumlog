<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use App\User;
use App\Blog;
use App\Comments;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('delete-post', function (User $user, Blog $post) {
            return $user->id == $post->created_by
                ? Response::allow()
                : Response::deny('Apenas quem criou o post ou o comentário pode excluir!');
        });

        Gate::define('delete-comment', function (User $user, Comments $comment) {
            return $user->tagname == $comment->comment_by
                ? Response::allow()
                : Response::deny('Apenas quem criou o post ou o comentário pode excluir!');
        });
    }
}
