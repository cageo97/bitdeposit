<?php
    namespace backend\controllers;

    class maincontrol extends controller {

        public function index($rq, $re, $args) {
            return $this->container->view->render($re, "index.twig");
        }

        public function account($rq, $re) {
            $userdata = $this->container->useractions->getby_id($_SESSION["uid"]);

            if($rq->isPost()) {
                $action = $rq->getParam("action");

                if($action == "generate" && empty($userdata["address"])) {
                    $newaddress = $this->container->bitcoin->getnewaddress()->result();
                    $this->container->useractions->updateaddress($_SESSION["uid"], $newaddress);
                    return $re->withRedirect("/account");
                }

                if($action == "withdrawal") {
                    
                    $validator = \Merkeleon\PhpCryptocurrencyAddressValidation\Validation::make('BTC');

                    $address = $rq->getParam("address");
                    $amount = floatval($rq->getParam("amount"));

                    if(empty($address) || empty($amount)) {
                        $error = "Please enter all fields";
                    } elseif(!$validator->validate($address)) {
                        $error = "Invalid Bitcoin address";
                    } elseif($amount < 0.001) {
                        $error = "Withdrawal amount must be more then 0.001 BTC";
                    } elseif($amount > $userdata["balance"]) {
                        $error = "You don't have that much Bitcoins";
                    } else {
                        $this->container->useractions->updatebalance($_SESSION["uid"], $amount*-1);
                        $this->container->paymentactions->create($_SESSION["uid"], 1, $address, "", $amount);
                        return $re->withRedirect("/account");
                    }
                }


            }

            return $this->container->view->render($re, "account.twig", [
                "userdata" => $userdata,
                "transactions" => $this->container->paymentactions->listby_uid($_SESSION["uid"]),
                "form" => [
                    "error" => $error,
                    "address" => $address,
                    "amount" => $amount
                ]
            ]);
        }

    }