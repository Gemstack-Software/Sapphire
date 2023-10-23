<?php
    namespace Sapphire\Styles;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\Asset\AssetInjector;
    use Sapphire\Exceptions\StyleNotFoundException;
    use Sapphire\Settings\SettingsManager;

    trait StyleRenderer { 
        /**
         * Rendering style
         */
        public function Render() {
            ///////////////////////////////////////////////////////////
            // Get style file
            ///////////////////////////////////////////////////////////
            $file = new File($this->file);
            if(!$file->Exists()) throw new StyleNotFoundException("Component Style $this->file was not found!");

            ///////////////////////////////////////////////////////////
            // Process style
            ///////////////////////////////////////////////////////////
            $content_nonminified = $file->Read();
            $content = $this->MinifyCss($content_nonminified);
            $content = $this->scoped ? $this->ScopeCss($content) : $content;

            ///////////////////////////////////////////////////////////
            // Create temp file path
            ///////////////////////////////////////////////////////////
            $extension = $file->GetExtension();
            $hash = hash('sha256', $this->file);

            $path_agent = new PathConstructor("@resources/~temp/$hash.$extension");
            $path = $path_agent->GetReal();

            ///////////////////////////////////////////////////////////
            // If styles need to be linked with <link>
            ///////////////////////////////////////////////////////////
            if(SettingsManager::GetSetting("Resources", "Link component styles with <link>")) {
                ///////////////////////////////////////////////////////////
                // Create temp file
                ///////////////////////////////////////////////////////////
                $temp = new File($path);
                $temp->Write($content);

                AssetInjector::InjectStyle($path);

                $temp->Delete();
            }
            else {
                echo "<style>";
                echo $content;
                echo "</style>";
            }
        }
    }