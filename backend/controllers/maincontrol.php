<?php
    namespace backend\controllers;

    class maincontrol extends controller {

        public function index($rq, $re, $args) {
            return $this->container->view->render($re, "index.twig");
        }

        public function account($rq, $re) {
            $userdata = $this->container->useractions->getby_id($_SESSION["uid"]);

            if($rq->isPost() && empty($userdata["address"])) {
                $newaddress = $this->container->bitcoin->getnewaddress()->result();
                $this->container->useractions->updateaddress($_SESSION["uid"], $newaddress);
                return $re->withRedirect("/account");
            }

            return $this->container->view->render($re, "account.twig", [
                "userdata" => $userdata
            ]);
        }

    }