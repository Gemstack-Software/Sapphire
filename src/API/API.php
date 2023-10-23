<?php
    namespace Sapphire\API;

    use Sapphire\Handle\Handleable;
    use Sapphire\App\App;
    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\Request\Request;

    /**
     * API Does not uses Sapphire\Router\Router
     * API Request is proccessed before Router is even initialized.
     * After done API Request Sapphire exit();
     * 
     */
    class API 
        implements Handleable {

        public function __constructor() {}

        /**
         * Check if current request is for api
         * 
         */
        public static function Request(): bool {
            $request_uri = $_SERVER["REQUEST_URI"];
            $uri_parts = explode("/", $request_uri);

            return $uri_parts[1] === "api";
        }

        /**
         * Handle api request
         * 
         * @param App $app - CMS App Handler
         */
        public function Handle(App $app): void {
            header('Content-Type: text/plain');

            // Getting the controllers list
            $controllers = $this->GetControllerList();

            // Request parts
            $request_uri = $_SERVER["REQUEST_URI"];
            $uri_parts = explode("/", $request_uri);

            if(count($uri_parts) < 4) $this->Exit(400, 'Invalid request');

            // Getting the controller
            $controller = @$controllers[$uri_parts[2]];

            // If controller does not exists then we exit with 404
            if(!$controller) $this->Exit(404, 'Controller not found!');

            // Creating an instance of controller
            $controller = new $controller;

            // Controller Exists so we're looking for method via url map
            $method_name = $controller->url_map[$uri_parts[3]] ?? null;
            if(!$method_name) $this->Exit(400, 'Invalid method');

            // Getting the reponse
            $response = $controller->{$method_name}(new Request, $app);

            // Exiting with response
            $this->ExitResponse($response);
        }

        private function Exit(int $status, string $text, array $data = []): void {
            $this->ExitResponse([
                'status' => $status,
                'message' => $text,
                'content' => $data
            ]);
        }

        private function ExitResponse(array $response): void {
            header('Content-Type: application/json');

            echo json_encode([
                'response' => $response
            ]);

            exit();
        }

        /**
         * Returns controller list
         */
        private function GetControllerList() {
            $controllers_list_path_agent = new PathConstructor('@/resources/api/ControllerList.php');
            $controllers_list_path = $controllers_list_path_agent->GetReal();
            $controllers_list = new File($controllers_list_path);
            $controllers = $controllers_list->Include();

            ////////////////////////////////////////
            // Controllers final list
            ////////////////////////////////////////
            $final_list = [];

            foreach($controllers as $key => $controller)
                $final_list[$key] = $controller;

            foreach(PluginControllerList::$list as $key => $controller)
                $final_list[$key] = $controller;
            
            return $final_list;
        }
    }