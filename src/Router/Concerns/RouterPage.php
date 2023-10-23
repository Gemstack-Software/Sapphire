<?php
    namespace Sapphire\Router\Concerns;

    use Sapphire\Router\RouterResource;
    use Sapphire\App\App;

    class RouterPage extends RouterResource {
        public function __construct(string $path, string $view) {
            $this->SetType(RouterResource::$Page);
            $this->SetPath($path);
            $this->SetLocation($view);
        }
        
        /**
         * Outputs the resource to standard output
         * 
         * @param App $app - App Handler
         */
        public function Echo(App $app): void {
            $app->View($this->GetLocation(), [
                'app' => $app
            ]);
        }
    }