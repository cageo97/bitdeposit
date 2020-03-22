<?php
    use backend\controllers\maincontrol;
    use backend\controllers\authcontrol;

    $slim->get('/', maincontrol::class . ':index')->setName("index");

    $slim->group('/auth', function(){
        $this->map(['get', 'post'], '/login', authcontrol::class . ':login');
        $this->map(['get', 'post'], '/register', authcontrol::class . ':register');
        $this->get('/logout', authcontrol::class . ':logout');
    });