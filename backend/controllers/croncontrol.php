<?php
    namespace backend\controllers;

    class croncontrol extends controller {

        public function checkaddresses($rq, $re) {
            
            foreach($this->container->bitcoin->listtransactions()->result() as $trans) {
                if(!$this->container->paymentactions->getby_txid($trans["txid"]) && $trans["confirmations"] >= 1) {
                    $this->container->paymentactions->create($trans["address"], $trans["txid"], $trans["amount"]);
                    $userdata = $this->container->useractions->getby_address($trans["address"]);
                    if($userdata) { $this->container->useractions->updatebalance($userdata["id"], $trans["amount"]); }
                }
            }

            // wtf was I doing?

            // foreach($this->container->useractions->list() as $user) {
            //     $balance = $this->container->bitcoin->getreceivedbyaddress($user["address"], 0)->result();
                
            //     $this->container->useractions->updatebalance($user["id"], $balance);
            // }

        }

    }