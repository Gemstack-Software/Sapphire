<?php
    namespace Sapphire\Layout;

    use Sapphire\Layout\Layout;
    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\Exceptions\LayoutNotExistsException;

    trait LayoutStatic {
        /**
         * @name Exists
         * @static
         * 
         * Checks if layout exists
         */
        public static function Exists(string $layout): bool {
            $path_agent = new PathConstructor("@resources/layouts/$layout/layout.json");
            $file = new File($path_agent->GetReal());

            return $file->Exists();
        }

        /**
         * @name Init
         * @static
         * 
         * Creates layout class by layout name
         */
        public static function Init(string $layout): Layout {
            $exists = Layout::Exists($layout);
            if(!$exists) throw new LayoutNotExistsException("Layout $layout is missing. Sapphire did not found this layout");

            $layout_class = new Layout;
            $layout_class->SetPath("@resources/layouts/$layout");
            $layout_class->Setup();

            return $layout_class;
        }

        /**
         * @name Layouts
         * @static
         * 
         * Returns all layouts avaliable
         */
        public static function Layouts(): array {
            $path_agent = new PathConstructor("@resources/layouts");
            $path = $path_agent->GetReal();
            
            $layouts_folder = new File($path);
            $layouts_files = $layouts_folder->NotSecretFilesProceed();
            $layouts = [];

            foreach($layouts_files as $layout_file) {
                $layouts[] = $layout_file->GetFilename();
            }

            return $layouts;
        }
    }