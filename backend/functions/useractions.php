<?php
    namespace backend\functions;

    use backend\models\users;

    class useractions {

        public function getby_email($email) {
            return users::where('email', $email)->first();
        }

        public function create($email, $password) {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            return users::create([
                "email" => $email,
                "password" => $password_hash
            ]);
        }

    }
