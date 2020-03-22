<?php
    define('APP_SESSION', true); // Setting to true will enable session_start for every page
    define('APP_DEBUG', true); // Setting to true will enable slim's debug mode (DO NOT LEAVE true IN PRODUCTION!)
    define('PHP_REPORTING', true); // Setting to true will enable PHP debugging, this might mess with Slim. (DO NOT LEAVE true IN PRODUCTION!)

    define('APP_TWIG', [
        "templates" => "../template_data",
        //"cache" =>  "../template_cache",
        "cache" => false
    ]);

    // this is just my local setup for mySQL. Please change this as needed
    define('CONFIG_MYSQL', [
        "driver" => "mysql",
        "host" => "172.17.0.1",
        "database" => "bitdeposit",
        "username" => "newuser",
        "password" => "password",
        "charset" => "utf8",
        "collation" => "utf8_unicode_ci"
    ]);

    define('CONFIG_BITCOIN', [
        "hostname" => "172.17.0.1",
        "username" => "bitcoinrpc",
        "password" => "password",
        "port" => 8332
    ]);