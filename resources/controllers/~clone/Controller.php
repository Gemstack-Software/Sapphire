<?php
    use Sapphire\Controller\ControllerManager;
    use Sapphire\App\App;
    use Sapphire\Request\Request;
    use Sapphire\Response\Response;

    class ExampleController {
        public array $url_map = [
            'status' => 'Status'
        ];

        /**
         * @name Status
         * @url /api/testapi-example/status
         * 
         * Returns controller status
         */
        public function Status(Request $request, App $app): array {
            return [
                'status' => 'Controller works fine!'
            ];
        }
    } 

    /**
     * Controller will be avaliable at url: /api/testapi-example/
     */
    ControllerManager::RegisterController (
        controller: ExampleController::class, 
        controller_path: 'example',
        unique_prefix: 'testapi'
    );