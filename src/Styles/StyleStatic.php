<?php
    namespace Sapphire\Styles;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;

    trait StyleStatic { 
        /**
         * Render the "global" style from "resources/styles"
         */
        public static function RenderGlobal(string $style): void {
            $path_agent = new PathConstructor("@resources/styles/$style/$style.css");
            
            $style = new Style($path_agent->GetReal());
            $style->Render();
        }

        /**
         * Move the style to public and link it
         */
        public static function Link(string $style): void {
            $path_agent = new PathConstructor("@resources/styles/$style/$style.css");
            $file = new File($path_agent->GetReal());

            $cloned_path_agent = new PathConstructor("@public/assets/styles/linked/$style.css");
            $file->Clone($cloned_path_agent->GetReal());

            echo '<link rel="stylesheet" href="/assets/styles/linked/' . $style . '.css">';
        }
    }