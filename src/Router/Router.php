<?php
    namespace Sapphire\Router;

    use Sapphire\Setup\SetupInterface;
    use Sapphire\Router\RouterSetup;
    use Sapphire\Router\RouterAdmin;
    use Sapphire\Router\RouterUtils;
    use Sapphire\Router\RouterAuth;
    use Sapphire\Router\RouterResource;
    use Sapphire\Router\Concerns\RouterPage;
    use Sapphire\Router\Concerns\PluginPage;
    use Sapphire\Response\Response;

    /**
     * Router for non-api paths
     */
    class Router
        implements SetupInterface {
        use RouterSetup;
        use RouterAdmin;
        use RouterUtils;
        use RouterAuth;

        /**
         * Stores the Request Path URL
         */
        private string $request_path;

        /**
         * Stores if user is in the admin panel
         */
        private bool $is_admin_panel;

        /**
         * Stores if user is in the "auth section" /admin/login
         */
        private bool $is_auth_section;

        /**
         * Resource type (if it's a page or image etc)
         */
        private string $resource_type;

        /**
         * Array with pages
         */
        private array $pages = [];

        public function __construct() {
            $this->Setup();
            
            $this->resource_type = RouterResource::$Page;
        }

        /**
         * Returns router state
         */
        public function IsAdminPanelRequest(): bool {
            return $this->is_admin_panel;
        }

        /**
         * Returns router state
         */
        public function IsAuthRequest(): bool {
            return $this->is_auth_section;
        }

        /**
         * Add router page to pages array
         */
        public function AddPage(string $path, string $view): void {
            $this->pages[] = new RouterPage($path, $view);
        }

        /**
         * Add plugin page to pages array
         */
        public function AddPluginPage(string $path, string $view, string $plugin_name, array $data): void {
            $this->pages[] = new PluginPage($path, $view, $plugin_name, $data);
        }
    
        /**
         * Returns resource that is being currently show
         */
        public function GetCurrentResource(): RouterResource {
            $path = $this->request_path;

            $page = null;      // Current page
            $page_star = null; // Page that location is * (it will show if $page will be null)

            foreach($this->pages as $page_item) {
                $uri_path = $page_item->GetPath();

                if($uri_path === "*") {
                    $page_star = $page_item;
                    continue;
                }

                if($uri_path === $path) {
                    $page = $page_item;
                    break;
                }
            }

            return $page ? $page : $page_star;
        }

        /**
         * Redirects request to other url
         */
        public function Redirect(string $new_url): void {
            Response::Redirect($new_url);
        }
    }