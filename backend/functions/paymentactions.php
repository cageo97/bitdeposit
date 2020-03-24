<?php
    namespace backend\functions;

    use backend\models\payments;

    class paymentactions {

        public function create($uid, $type, $address, $txid, $amount) {
            return payments::create([
                "uid" => $uid,
                "type" => $type,
                "address" => $address,
                "txid" => $txid,
                "amount" => $amount
            ]);
        }

        public function getby_txid($txid) {
            return payments::where('txid', $txid)->first();
        }

        public function listpending() {
            return payments::where('txid', '')->get();
        }

        public function updatetxid($id, $txid) {
            return payments::where('id', $id)->update(["txid" => $txid]);
        }

        public function listby_uid($uid) {
            return payments::where('uid', $uid)->orderBy('id', 'DESC')->get();
        }

    }
