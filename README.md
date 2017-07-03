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
       
       
5 - Adicionar Modules no autoload do composer.json
       
              {
        "autoload": {
       "psr-4": {
       "App\\": "app/",
       "Modules\\": "Modules/"
       }
              }      
                     }
                     
6 -  Modificar o arquivo Config\Modulos.php  scan: 
Mudar enabled para true.
       
       'scan' => [
        'enabled' => true,
        'paths' => [
            base_path('vendor/*/*'),
        ],
    ],
    

7 - Instalar  https://github.com/uxweb/sweet-alert

8 - Baixar o plugin do sweet-alert2 e jogar os arquivos na raiz do diretorio de \public\plugins

9 - Carregar os arquivos em: Resources\views\layouts\adminlte\layouts\partials\htmlheader.blade.php

    <!-- SweetAlert -->
      <script src="{{asset('plugins/sweetalert2.min.js')}} "></script>
      <link rel="stylesheet" type="text/css" href="{{asset('plugins/sweetalert2.css')}} ">
    <!-- End SweetAlert -->
    
10 - Configurar o layout principal app.blade.php, na linha 56
 @include('sweet::alert')'
  

11 - Configurar o acesso ao banco de dados e a engine do banco config\database mysql. 

      engine' => 'InnoDB',
      
12 - Rodar as migrações normais (para criar a tabela de usrs na primeira instalação)

      php artisan migrate

13 - Instalar o componente  

      composer require whande1992/laravel-acl": "1.0.0.*
  
 14 - Rodar a migrate para inserir as tabelas do modulo]
      
      php artisan module:migrate
      
15 - Rodar o seed para popular o banco de dados com informações padrão    
      
      php artisan module:seed
      
      
 Para conferir se tudo esta ok, acessar o link \grupos e verificar se existe o grupo adminsitrados.

