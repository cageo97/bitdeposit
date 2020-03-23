<?php
    namespace backend\functions;

    use backend\models\payments;

    class paymentactions {

        public function create($address, $txid, $amount) {
            return payments::create([
                "address" => $address,
                "txid" => $txid,
                "amount" => $amount
            ]);
        }

        public function getby_txid($txid) {
            return payments::where('txid', $txid)->first();
        }

    }
