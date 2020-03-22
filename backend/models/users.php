<?php
    namespace backend\models;

    use Illuminate\Database\Eloquent\Model;

    class users extends Model {

        protected $table = "users";

        protected $fillable = [
            "email",
            "password",
            "balance",
            "address"
        ];

        protected $attributes =[
            "balance" => 0,
            "address" => ""
        ];

    }