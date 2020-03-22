<?php
    namespace backend\controllers;

    class maincontrol extends controller {

        public function index($rq, $re, $args) {
            return $this->container->view->render($re, "index.twig");
        }

        public function account($rq, $re) {
            return $this->container->view->render($re, "account.twig");
        }

    }