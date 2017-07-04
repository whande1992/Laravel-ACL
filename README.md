# Laravel-ACL
Grupos de usuários e permissões de acesso para Laravel 5.4.

Antes de instalar o modulo, é necessario ter o laravel funcionando, com o tema AdminLte instalado, não é necessario criar um usuario inicial, pois o modulo cria automaticamente um usuario administrador

User: suporte@autmaster.com.br

Senha: padrao autmaster



## Laravel 5.4

1 - Requer Laravel-Modules

      composer require nwidart/laravel-modules
      
2 - Adicionar Service Provider em config/app.php.
      
```php
      'providers' => [
            Nwidart\Modules\LaravelModulesServiceProvider::class,
      ],
```

3 - Adicionar em aliases :

```php
   'aliases' => [
           'Module' => Nwidart\Modules\Facades\Module::class,
      ],
```

       
4 - Publicar        
       
      php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
       
       
5 - Adicionar Modules no autoload do composer.json

```php      
      {
       "autoload": {
       "psr-4": {
       "App\\": "app/",
       "Modules\\": "Modules/"
       }
         }      
           }
```
                     
6 -  Modificar o arquivo Config\Modulos.php  scan: 
Mudar enabled para true.

```php
      'scan' => [
       'enabled' => true,
       'paths' => [
        base_path('vendor/*/*'),
        ],
      ],
```
    

7 - Instalar SweetAlert 

      https://github.com/uxweb/sweet-alert

8 - Navegar até o diretório \public\plugins e baixar o SweetAlert

      $ bower install sweetalert2

9 - Carregar os arquivos em: Resources\views\layouts\adminlte\layouts\partials\htmlheader.blade.php

```php
      <!-- SweetAlert -->
      <script src="{{asset('plugins/bower_components/sweetalert2/dist/sweetalert2.min.js')}} "></script>
      <link rel="stylesheet" type="text/css" href="{{asset('plugins/bower_components/sweetalert2/dist/sweetalert2.css')}} ">
      <!-- End SweetAlert -->
```
    
10 - Configurar o layout principal app.blade.php, na linha 55 em baixo de @include('adminlte::layouts.partials.footer')

```php
      @include('sweet::alert')
```
 
 Na linha 44 em baixo de  @include('adminlte::layouts.partials.contentheader')

```php
      @if ($errors->any())
            <script>
                swal(   'Atenção!',
                        ' {!! $errors->first() !!} ',
                        'error'
                    )
            </script>
        @endif
```

11 - Configurar o acesso ao banco de dados e a engine do banco config\database mysql. 

```php
      engine' => 'InnoDB',
```

12 - Rodar as migrações normais (para criar a tabela de usrs na primeira instalação)

      php artisan migrate

13 - Instalar o componente  

      composer require whande1992/laravel-acl": "1.0.0.*
  
 14 - Rodar a migrate para inserir as tabelas do modulo]
      
      php artisan module:migrate
      
15 - Rodar o seed para popular o banco de dados com informações padrão    
      
      php artisan module:seed
      
      
 Para conferir se tudo esta ok, acessar o link \grupos e verificar se existe o grupo adminsitrados.


