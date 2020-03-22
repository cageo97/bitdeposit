<?php
    use backend\controllers\maincontrol;
    use backend\controllers\authcontrol;

    // middleware
    use backend\middleware\uacmiddleware;

    $slim->group('', function() {
        $this->get('/', maincontrol::class . ':index')->setName("index");
        $this->map(['get', 'post'], '/account', maincontrol::class . ':account')->setName("account");
        $this->get('/logout', authcontrol::class . ':logout');
    })->add(new uacmiddleware($container, true, "/auth/login"));

    $slim->group('', function() {
        $this->group('/auth', function(){
            $this->map(['get', 'post'], '/login', authcontrol::class . ':login');
            $this->map(['get', 'post'], '/register', authcontrol::class . ':register');
        });
    })->add(new uacmiddleware($container, false, "/"));