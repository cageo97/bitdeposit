<?php
    namespace backend\middleware;

    class uacmiddleware {

        public $container;
        public $switch;
        public $url;

        public function __construct($container, $switch, $url) {
            $this->container = $container;
            $this->switch = $switch;
            $this->url = $url;
        }
        
        public function __invoke($request, $response, $next) {
            if((bool)$_SESSION["uid"] != $this->switch) {
                return $response->withRedirect($this->url);
            }

            return $next($request, $response);
        }

    }