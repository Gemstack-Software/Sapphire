<?php
    namespace Sapphire\Component;

    use Sapphire\Compilers\OnyxCompiler;
    use Sapphire\File\File;
    use Sapphire\Json\Json;
    
    trait ComponentRenderer {
        /**
         * Renders component by including it
         * 
         * =========================================================================================
         * EXPLANATIONS
         * =========================================================================================
         * 
         * Hash: Each component has unique hash that is it's name + .onyx
         *       hashed via sha256 to be unique but all instances of this component
         *       have its the same so it can be used e.g. for scoping css
         * 
         *       We're using the $this->View() because component does not contain
         *       any other unique info about itself
         * 
         * =========================================================================================
         */
        public function Render(\stdClass | array $data = []): void {
            global $app;

            if($data === []) $data = $this->params;

            ///////////////////////////////////////////////////////////
            // Settuping onyx compiler
            ///////////////////////////////////////////////////////////
            Component::$OnyxCompiler ??= new OnyxCompiler;
            
            ///////////////////////////////////////////////////////////
            // Running component::View function to get view
            ///////////////////////////////////////////////////////////
            $view = $this->View();

            ///////////////////////////////////////////////////////////
            // Rendering the onyx or php or html file
            ///////////////////////////////////////////////////////////
            $file = new File("$this->component_folder/$view");

            if($file->IsOnyx())
                $file = Component::$OnyxCompiler->Compile($file);
            
            ///////////////////////////////////////////////////////////
            // Component scoping
            ///////////////////////////////////////////////////////////
            $hash = hash('sha256', $this->View());

            echo '<root unique="' . $this->component_id . '" hash="' . $hash . '">';
                $file->Include([ 
                    "__component" => $this,
                    "props" => $this,
                    "params" => Json::Make($data),
                    "app" => $app
                ]);
            echo "</root>";
        }
    }