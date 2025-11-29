<?php
use App\repositories\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

use App\Middleware\Authorization;
use App\Middleware\Role;


return function (App $app) {

    //  raíz del microservicio
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write("Hello usuarios!");
        return $response;
    });

    $app->group('/usuarios', function (RouteCollectorProxy $group) {

        // ---- RUTAS ----
        $group->get('/all', [UserRepository::class, 'queryAllUsuarios'])
            ->add(new Role(['admin']))
            ->add(new Authorization());

        $group->post('/register', [UserRepository::class, 'registrarUsuario']);

        $group->post('/login', [UserRepository::class, 'login']);

        $group->get('/profile', [UserRepository::class, 'miPerfil'])
            ->add(new Authorization());

        $group->post('/logout', [UserRepository::class, 'logout'])
            ->add(new Authorization());

        $group->get('/validate-token', [UserRepository::class, 'validarToken'])
            ->add(new Authorization());

        // ---- RUTAS DINÁMICAS ----
        $group->get('/{id}', [UserRepository::class, 'obtenerUsuario'])
            ->add(new Authorization())
            ->add(new Role(['admin']));

        $group->put('/{id}', [UserRepository::class, 'actualizarUsuario'])
            ->add(new Authorization())
            ->add(new Role(['admin']));

        $group->delete('/{id}', [UserRepository::class, 'eliminarUsuario'])
            ->add(new Authorization())
            ->add(new Role(['admin']));

    });
};
