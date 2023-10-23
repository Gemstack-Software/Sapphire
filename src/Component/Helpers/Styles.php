<?php
    namespace Sapphire\Component\Helpers;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\Styles\Style;

    trait Styles {
        public function Styles(string $style = '', bool $scope = false): void {
            ///////////////////////////////////////////////////////////
            // Getting component's hash
            ///////////////////////////////////////////////////////////
            $hash = hash('sha256', $this->View());

            ///////////////////////////////////////////////////////////
            // Checks if style was rendered
            ///////////////////////////////////////////////////////////
            if(Style::HasComponentStyle($hash)) return;

            ///////////////////////////////////////////////////////////
            // Getting the style
            ///////////////////////////////////////////////////////////
            $path_agent = new PathConstructor("$this->component_folder/$style");

            ///////////////////////////////////////////////////////////
            // Rendering style
            ///////////////////////////////////////////////////////////
            $style = new Style($path_agent->GetReal());
            $style->SetScoped($scope, $hash);
            $style->Render();

            ///////////////////////////////////////////////////////////
            // Saving that style was rendered
            ///////////////////////////////////////////////////////////
            Style::ComponentStyleRendered($hash);
        }
    }