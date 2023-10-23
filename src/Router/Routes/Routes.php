<?php
    namespace Sapphire\Router\Routes;

    use Sapphire\Router\Router;

    trait Routes {
        public function ApplyRoutes(Router $router): void {
            $router->AddPage('/admin', 'admin/Home');
            $router->AddPage('/admin/app', 'admin/App');
            $router->AddPage('/admin/pages', 'admin/Pages');
            $router->AddPage('/admin/content', 'admin/Content');
            $router->AddPage('/admin/assets', 'admin/Assets');
            $router->AddPage('/admin/login', 'admin/Login');
            $router->AddPage('/admin/disk', 'admin/Disk');
            $router->AddPage('/admin/plugins', 'admin/Plugins');
            $router->AddPage('/admin/settings', 'admin/Settings');
            $router->AddPage('/admin/account', 'admin/Account');

            // Handling pages
            $router->AddPage('*', 'client/Page');
        }
    }