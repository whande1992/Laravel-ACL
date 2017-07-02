<?php

namespace Modules\GruposDeAcesso\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\GruposDeAcesso\Entities\Permission;

class GruposDeAcessoServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();

        /*Verifica se a tabela existe para fazer a validação de acessos*/
        if (Schema::hasTable('permissions')) {
            /*Retorna todos os Grupos que estão ligados a cada permissão*/

            $permissions = Permission::with('roles')->get();

            foreach ($permissions as $permission) {
                Gate::define($permission->nome, function (User $user) use ($permission) {
                    return $user->hasPermission($permission);
                });
            }

            Gate::before(function (user $user) {

                if ($user->hasAnyRoles('Administrador'))
                    return true;

            });
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('gruposdeacesso.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'gruposdeacesso'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/gruposdeacesso');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/gruposdeacesso';
        }, \Config::get('view.paths')), [$sourcePath]), 'gruposdeacesso');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/gruposdeacesso');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'gruposdeacesso');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'gruposdeacesso');
        }
    }

    /**
     * Register an additional directory of factories.
     * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {


        return [];
    }
}
