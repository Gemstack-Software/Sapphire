<?php
    namespace Sapphire\App;

    use Sapphire\Setup\SetupInterface;
    use Sapphire\Database\Database;
    use Sapphire\User\User;
    use Sapphire\API\API;
    use Sapphire\Router\Router;
    use Sapphire\Router\Routes\Routes;
    use Sapphire\Settings\SettingsManager;
    use Sapphire\Minifier\HTMLMinifier;
    use Sapphire\Controller\ControllerManager;

    trait AppSetup {
        use Routes;

        public function Setup(): void {
            global $app;

            /////////////////////////////
            // Start session
            /////////////////////////////
            session_set_cookie_params(SettingsManager::GetSetting("Optional features", "Session lifetime"), "/");
            session_start();

            ////////////////////////////
            // Minify
            ////////////////////////////
            if(SettingsManager::GetSetting("Production", "Minify response")) ob_start([HTMLMinifier::class, 'Minify']);

            /////////////////////////////
            // Bind app to this
            /////////////////////////////
            $app = $this;

            /////////////////////////////
            // Setup all factories
            /////////////////////////////
            $this->database = new Database($this->GetLock()->database);

            ControllerManager::SetupControllers();

            $this->CheckIfAnyUser();
            $this->user = User::Session();

            $this->SetupRouter();
            $this->LoadPlugins();
            $this->CheckIfUserIsNew();

            $this->CheckIfApiRequest();
            $this->resource->Echo($this);
        }

        private function CheckIfAnyUser(): void {
            if($table = $this->database->GetTable('sapphire_users')) {
                $any_user = $table->HasAnyRecord();

                if(!$any_user) $this->SetupUser();
            }
        }

        private function SetupUser(): void {
            if(API::Request()) return;

            $this->View('install/SetupUser', ['app' => $this]);
            exit();
        }

        /**
         * Checks if user which is logged in is new and requires setup
         */
        private function CheckIfUserIsNew(): void {
            if(API::Request()) return;
            if(!$this->user->IsNew()) return;
            
            $this->View('admin/NewUserSetup', ['app' => $this]);
            exit();
        }

        private function CheckIfApiRequest() {
            if(API::Request()) {
                $this->api = new API;
                $this->api->Handle($this);

                exit();
            }
        }

        private function SetupRouter(): void {
            $this->router = new Router;
            $this->CheckIfAuthNeeded();
            $this->ApplyRoutes($this->router);
            
            $this->SetupResource();
        }

        public function SetupResource(): void {
            $this->resource = $this->router->GetCurrentResource();
        }

        private function CheckIfAuthNeeded(): void {
            $is_authorized = !$this->user->IsGuest();
            $is_admin_request = $this->router->IsAdminPanelRequest();
            $is_auth_request = $this->router->IsAuthRequest();

            /////////////////////////////
            // When it's admin panel request that is not a login page and user is not logged then we gonna redirect to login page
            /////////////////////////////
            if($is_admin_request && !$is_authorized && !$is_auth_request) {
                $this->router->Redirect('/admin/login');
            }
        }
    }