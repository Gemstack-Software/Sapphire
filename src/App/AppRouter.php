<?php
    namespace Sapphire\App;

    use Sapphire\Router\Router;

    trait AppRouter {
        /**
         * Returns router
         */
        public function GetRouterHandler(): Router {
            return $this->router;
        }
    }