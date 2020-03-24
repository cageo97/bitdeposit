<?php
    namespace backend\controllers;

    class croncontrol extends controller {

        public function checkpayments($rq, $re) {
            
            foreach($this->container->bitcoin->listtransactions()->result() as $trans) {
                if(!$this->container->paymentactions->getby_txid($trans["txid"]) && $trans["confirmations"] >= 1) {
                    $userdata = $this->container->useractions->getby_address($trans["address"]);    
                    if($userdata) {
                        $this->container->paymentactions->create($userdata["id"], 0, $trans["address"], $trans["txid"], $trans["amount"]);
                        $this->container->useractions->updatebalance($userdata["id"], $trans["amount"]);
                    }
                }
            }

        }

        public function withdrawal($rq, $re) {

            foreach($this->container->paymentactions->listpending() as $pay) {
                $txid = $this->container->bitcoin->sendtoaddress($pay["address"], $pay["amount"], "", "", true)->result();
                $this->container->paymentactions->updatetxid($pay["id"], $txid);
            }

        }

    }