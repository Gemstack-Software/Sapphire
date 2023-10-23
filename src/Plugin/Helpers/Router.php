<?php
    namespace Sapphire\Plugin\Helpers;

    trait Router {
        public function AddRoute(
            string $path,
            string $view,
            array $data = []
        ): void {
            global $app;

            $router = $app->GetRouterHandler();
            $router->AddPluginPage($path, $view, $this->GetName(), $data);

            $app->SetupResource();
        }
    }