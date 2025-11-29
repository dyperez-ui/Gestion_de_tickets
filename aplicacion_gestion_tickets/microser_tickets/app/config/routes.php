<?php
use App\Repositories\TicketRepository;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Middleware\Authorization;
use App\Middleware\Role;

return function (App $app) {
// Rutas para la gestión de tickets
    $app->group('/tickets', function (RouteCollectorProxy $group) {
        $group->get('/search', [TicketRepository::class, 'buscar'])
            ->add(new Role(['admin']))    
            ->add(new Authorization());
        // Rutas protegidas por autenticación y autorización
        $group->post('/create', [TicketRepository::class, 'crear'])
            ->add(new Role(['gestor']))
            ->add(new Authorization());
        // Rutas para ver, asignar y cambiar estado de tickets
        $group->get('/mine', [TicketRepository::class, 'misTickets'])
            ->add(new Role(['gestor']))
            ->add(new Authorization());
        // Rutas para administradores
        $group->get('/all', [TicketRepository::class, 'todos'])
            ->add(new Role(['admin']))
            ->add(new Authorization());
        // Rutas para ver detalles, asignar, cambiar estado, agregar comentarios y actividades
        $group->get('/{id}', [TicketRepository::class, 'ver'])
            ->add(new Authorization());

        $group->put('/{id}/assign', [TicketRepository::class, 'asignar'])
            ->add(new Role(['admin']))
            ->add(new Authorization());
            
        $group->put('/{id}/estado', [TicketRepository::class, 'cambiarEstado'])
            ->add(new Role(['admin']))
            ->add(new Authorization());
        
        $group->get('/{id}/actividades', [TicketRepository::class, 'actividades'])
            ->add(new Role(['admin']))
            ->add(new Authorization());
        
        $group->post('/{id}/comentarios', [TicketRepository::class, 'agregarComentario'])
            ->add(new Authorization());
        
        $group->post('/{id}/actividad', [TicketRepository::class, 'agregarActividad'])
            ->add(new Authorization()); 
        


    });
};
