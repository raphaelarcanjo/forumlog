<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogComment;

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

        Gate::define('delete-blog', function (User $user, Blog $blog) {
            return $user->id == $blog->user_id
                ? Response::allow()
                : Response::deny('Apenas quem criou o post ou o comentário pode excluir!');
        });

        Gate::define('delete-comment', function (User $user, BlogComment $comment) {
            return $user->id == $comment->user_id
                ? Response::allow()
                : Response::deny('Apenas quem criou o post ou o comentário pode excluir!');
        });
    }
}
