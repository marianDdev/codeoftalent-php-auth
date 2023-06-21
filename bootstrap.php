<?php

use App\App;
use App\Container;
use App\Controller\LoginController;
use App\Controller\AbcController;
use App\Repository\UserRepository;
use App\Service\DatabaseService;
use App\Service\TokenService;

$container = new Container();

$container->bind(LoginController::class, function () {
    $databaseService = new DatabaseService;
    $userRepository = new UserRepository($databaseService);
    $tokenservice = new TokenService();

    return new LoginController($userRepository, $tokenservice);
});

App::setContainer($container);
