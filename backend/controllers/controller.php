<?php
    namespace backend\controllers;

    use Psr\Container\ContainerInterface;

    abstract class controller {
        protected $container;

        public function __construct(ContainerInterface $container) {
            $this->container = $container;
        }
    }