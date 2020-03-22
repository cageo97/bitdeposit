<?php
    use backend\controllers\maincontrol;

    $slim->get('/', maincontrol::class . ':index')->setName("index");