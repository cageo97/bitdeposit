<?php
    namespace backend\controllers;

    class croncontrol extends controller {

        public function checkaddresses($rq, $re) {
            
            foreach($this->container->useractions->list() as $user) {
                $balance = $this->container->bitcoin->getreceivedbyaddress($user["address"], 0)->result();
                
                $this->container->useractions->updatebalance($user["id"], $balance);
            }

        }

    }