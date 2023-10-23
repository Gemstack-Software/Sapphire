<?php
    namespace Sapphire\Router\Concerns;

    use Sapphire\Router\RouterResource;
    use Sapphire\App\App;
    use Sapphire\Plugin\PluginLoader;

    class PluginPage extends RouterResource {
        private string $plugin_name;
        private array $data;

        public function __construct(string $path, string $view, string $plugin_name, array $data) {
            $this->SetType(RouterResource::$Page);
            $this->SetPath($path);
            $this->SetLocation($view);
            $this->plugin_name = $plugin_name;
            $this->data = $data;
        }
        
        /**
         * Outputs the resource to standard output
         * 
         * @param App $app - App Handler
         */
        public function Echo(App $app): void {
            $plugin = PluginLoader::Get($this->plugin_name);
            
            $app->View('admin/Custom', [
                'app' => $app,
                'container' => [
                    'name' => $this->GetLocation(),
                    'root_folder' => $plugin->GetPath() . '/views/',
                    'params' => $this->data
                ],
            ]);
        }
    }