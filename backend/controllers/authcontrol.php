<?php
    namespace backend\controllers;

    class authcontrol extends controller {

        public function login($rq, $re) {
            return $this->container->view->render($re, "auth/login.twig");
        }

        public function register($rq, $re) {

            if($rq->isPost()) {
                $email = $rq->getParam("email");
                $password = $rq->getParam("password");
                $password_confirm = $rq->getParam("password_confirm");

                if(empty($email) || empty($password) || empty($password_confirm)) {
                    $error = "All fields are empty";
                } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = "Invalid email format";
                } elseif($this->container->useractions->getby_email($email)) {
                    $error = "Email already in use";
                } elseif($password != $password_confirm) {
                    $error = "Passwords must match";
                } else {
                    $uid = $this->container->useractions->create($email, $password);
                    $_SESSION["uid"] = $uid;
                    return $re->withRedirect('/');
                }
            }

            return $this->container->view->render($re, "auth/register.twig", [
                "form" => [
                    "error" => $error,
                    "email" => $email
                ]
            ]);
        }

        public function logout($rq, $re) {
            unset($_SESSION["uid"]);
            return $re->withRedirect('/');
        }

    }