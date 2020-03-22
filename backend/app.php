<?php
    // include autoload file from composer
    require "../vendor/autoload.php";

    // include application config file
    require "appconfig.php";

    // enable application sessions
    if(APP_SESSION) {
        session_start();
    }

    // enable php error reporting
    if(PHP_REPORTING) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    $slim = new \Slim\App([
        "settings" => [
            "displayErrorDetails" => APP_DEBUG,
            "debug" => APP_DEBUG,
            "twig" => APP_TWIG
        ],
        "config" => [
            "mysql" => CONFIG_MYSQL
        ]
    ]);

    $container = $slim->getContainer();

    // connect to mysql database using Eloquent
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container["config"]["mysql"]);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    // start twig template engine
    $container["view"] = function($container) {
        $view = new \Slim\Views\Twig($container["settings"]["twig"]["templates"], [
            "cache" => $container["settings"]["twig"]["cache"]
        ]);
        $view->addExtension(new \Slim\Views\TwigExtension(
            $container->router,
            $container->request->getUri()
        ));
        return $view;
    };

    // handel application 404
    $container["notFoundHandler"] = function($container) {
        return function ($rq, $re) use ($container) {
            return $container["view"]->render($re->withStatus(404), "404.twig");
        };
    };

    // handel application 50x if not in debug mode
    if(APP_DEBUG === false) {
        $container["errorHandler"] = function($container) {
            return function ($rq, $re) use ($container) {
                return $container["view"]->render($re->withStatus(500), "500.twig");
            };
        };
    }

    $container["useractions"] = function($container) {
        return new \backend\functions\useractions;
    };

    // include application routes
    require "approutes.php";