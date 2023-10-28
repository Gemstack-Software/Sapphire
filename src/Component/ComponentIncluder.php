<?php
    namespace Sapphire\Component;

    use Sapphire\Component\Component;
    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;

    trait ComponentIncluder {
        /**
         * @name IncludeClientComponent
         * 
         * Includes client's component (from @/resources/components)
         */
        public function IncludeClientComponent(string $name, array|\stdClass $data = []): void {
            // Component folder path
            $path_agent = new PathConstructor("@resources/components/$name");
            $path = $path_agent->GetReal();

            // Including the ".component.php" file (class)
            $file = new File($path . "/$name.component.php");
            $component = $file->Include();

            if(!$component) return;

            // Set path to component's folder
            $component->SetComponentFolderPath($path);

            // Pass props
            $component->SetParams($data);

            // Before rendering we should trigger Mounted event
            $component->Mounted();

            // Rendering component
            $component->Render();
        }
    }