<?php
    namespace Sapphire\Api\Controllers;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\App\App;
    use Sapphire\Request\Request;
    use Sapphire\Response\Response;
    use Sapphire\User\User;

    class Components {
        public array $url_map = [ 
            'render' => 'RenderComponentWithPassedData'
        ];

        /**
         * Provides username and avatar whilst siging-in for showing after passing username or email
         */
        public function RenderComponentWithPassedData(Request $request, App $app): array {
            $data = $request->GetContent();
            $component_name = $request->GetParamByIndex(0);

            /////////////////////////////////////
            // Get component by path
            /////////////////////////////////////
            $path_agent = new PathConstructor("@resources/components/$component_name");
            $component_path = $path_agent->GetReal();

            $component_file = new File($component_path . "/$component_name.component.php");
            $component = $component_file->Include();

            /////////////////////////////////////
            // Pass properties
            /////////////////////////////////////
            $component->SetComponentId($data->unique);
            $component->SetComponentFolderPath($component_path);
            $component->SetParams($data->parameters);

            ////////////////////////////////////
            // Mount component
            ////////////////////////////////////
            $component->Mounted();

            ////////////////////////////////////
            // Change state
            ////////////////////////////////////
            foreach($data->state_changes as $key => $value) {
                $component->{$key} = $value;
            }

            ////////////////////////////////////
            // Re-render component
            ////////////////////////////////////
            $component->Render([], $component_name);

            return Response::HTML('');
        }
    }