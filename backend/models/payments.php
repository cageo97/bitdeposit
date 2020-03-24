<?php
    namespace backend\models;

    use Illuminate\Database\Eloquent\Model;

    class payments extends Model {

        protected $table = "payments";

        protected $fillable = [
            "uid",
            "type",
            "address",
            "txid",
            "amount"
        ];

    }