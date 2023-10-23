<?php
    namespace Sapphire\Router;

    trait RouterSetup {
        public function Setup(): void {
            $this->request_path = $_SERVER["REQUEST_URI"];
            $this->is_admin_panel = $this->CheckIfIsAdminPanel();
            $this->is_auth_section = $this->CheckIfIsAuth(); 

            
        }
    }