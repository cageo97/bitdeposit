<?php
    use backend\controllers\maincontrol;
    use backend\controllers\authcontrol;
    use backend\controllers\croncontrol;

    // middleware
    use backend\middleware\uacmiddleware;

    // uacmiddleware
    // true = needs to be logged in
    // false = needs to be logged out
    // if uacmiddleware not added to route anyone can view it

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

    $slim->get('/crons/checkaddresses', croncontrol::class . ':checkaddresses')->setName("crons.checkaddresses");