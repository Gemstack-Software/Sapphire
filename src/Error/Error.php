<?php
    namespace Sapphire\Error;

    use Exception;

    class ErrorHandler {
        public function Exception($exception) {
            global $app;

            $app->View('errors/Exception', [ 
                'exception' => $exception,
                'app' => $app
            ]);

            exit();
        }
    }