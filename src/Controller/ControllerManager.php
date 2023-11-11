<?php
    namespace Sapphire\Controller;

    use Sapphire\API;
    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;

    class ControllerManager {
        /**
         * Registers client controller
         */
        public static function RegisterController(
            string $controller,
            string $controller_path,
            string $unique_prefix
        ): void {
            \Sapphire\Api\PluginControllerList::$list["$unique_prefix-$controller_path"] = $controller;
        }

        /**
         * Register controllers
         */
        public static function SetupControllers(): void {
            $path = (new PathConstructor("@resources/controllers"))->GetReal();
            $folder = new File($path);

            foreach($folder->NotSecretFilesProceed() as $folder) {
                $controller = $folder->GetChild("Controller.php");
                $controller->Include();
            }
        }
    }