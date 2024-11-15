<?php
    
    require_once 'libraries/router.php';

    require_once 'apps/controllers/genero.controller.php';
    require_once 'apps/controllers/pelicula.controller.php';
    require_once 'apps/controllers/user.controller.php';
    require_once 'apps/middleware/jwt.auth.middleware.php';

    $router = new Router();
    $router->addMiddleware(new JWTAuthMiddleware());

    #                 endpoint       verbo      controller              metodo
    $router->addRoute('generos',     'GET',     'GeneroController',     'getAll');
    $router->addRoute('generos/:id', 'GET',     'GeneroController',     'get');
    $router->addRoute('generos/:id', 'DELETE',  'GeneroController',     'delete');
    $router->addRoute('generos',     'POST',    'GeneroController',     'create');
    $router->addRoute('generos/:id', 'PUT',     'GeneroController',     'update');

    $router->addRoute('peliculas',       'GET',        'PeliculaController',   'getAll');
    $router->addRoute('peliculas/:id',   'GET',        'PeliculaController',   'get');
    $router->addRoute('peliculas/:id',   'DELETE',     'PeliculaController',   'delete');
    $router->addRoute('peliculas',       'POST',       'PeliculaController',   'create');
    $router->addRoute('peliculas/:id',   'PUT',        'PeliculaController',   'update');

    $router->addRoute('user/token',      'GET',        'UserController',       'getToken');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);