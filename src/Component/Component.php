<?php
    namespace Sapphire\Component;

    use Sapphire\Component\ComponentRenderer;
    use Sapphire\Component\ComponentEvents;
    use Sapphire\Compilers\OnyxCompiler;

    /**
     * + =================================================== +
     * | Disclaimer                                          |
     * + =================================================== +
     * 
     * Component class does NOT uses Sapphire\View\View::class
     * Because it's strictly used in View's used in router
     */
    class Component {
        use ComponentRenderer;
        use ComponentEvents;

        /**
         * Agent of OnyxCompiler
         */
        public static $OnyxCompiler;

        /**
         * Component unique id
         */
        protected string $component_id = "";

        /**
         * Path of component folder
         */
        protected string $component_folder = "";

        /**
         * Set path of component's folder
         */
        public function SetComponentFolderPath(string $path): void {
            $this->component_folder = $path;
        }

        /**
         * Get the property of Components (passed e.g. in Topbar.component.php) which contains some data
         */
        public function Get(string $property) {
            return @$this->{$property};
        }

        /**
         * Constructor
         */
        public function __construct() {
            $this->component_id = uniqid();
        }
    }