<?php
    namespace Sapphire\View;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;

    class View {
        private string $name;
        private array $data;
        private string $root_folder;

        public function __construct(string $name, array $data = [], string $root_folder = '@/resources/views/') {
            $this->name = $name;
            $this->data = $data;
            $this->root_folder = $root_folder;
        }

        /**
         * Renders our view (include .php file)
         */
        public function Render(): void {
            $view_path_agent = new PathConstructor($this->root_folder . "$this->name.php");
            $view_path = $view_path_agent->GetReal();

            $view = new File($view_path);
            $view->Include($this->data);
        }

        /**
         * Render view staticly (used by Viewable::View)
         */
        public static function View(string $name, array $data = [], string $root_folder = '@/resources/views/'): void {
            $view = new View($name, $data, $root_folder);
            $view->Render();
        }
    }