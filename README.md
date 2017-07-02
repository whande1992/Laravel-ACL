# Laravel-ACL
Grupos de usuários e permissões de acesso.

Install

# Laravel 5.4

1 - Requer Laravel-Modules

      composer require nwidart/laravel-modules
      
2 - Adicionar Service Provider em config/app.php.
      
      'providers' => [
               Nwidart\Modules\LaravelModulesServiceProvider::class,
       ],
3 - Adicionar em aliases :

       'aliases' => [
             'Module' => Nwidart\Modules\Facades\Module::class,
       ],
       
       
4 - Publicar        
       
       php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
       
       
5 - Adicionar Modules no autoload
       
              {
        "autoload": {
       "psr-4": {
       "App\\": "app/",
       "Modules\\": "Modules/"
       }
              }      
                     }
                     
6 -  Em Config\Modulos.php  scan: 
       
       'scan' => [
        'enabled' => false,
        'paths' => [
            base_path('vendor/*/*'),
        ],
    ],
    

7 - Instalar  https://github.com/uxweb/sweet-alert
  

8 - Configurar o acesso ao banco de dados e a engine do banco config\database mysql. 

      engine' => 'InnoDB',

      composer require whande1992/laravel-acl
  
      composer module:seed


