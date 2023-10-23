<?php
    namespace Sapphire\Layout;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\Compilers\OnyxCompiler;

    trait LayoutSetup {
        public function Setup(): void {
            Layout::$OnyxCompiler ??= new OnyxCompiler;

            $this->config = $this->SetupConfig();
        }

        /**
         * @name SetupConfig
         * 
         * Parse layout config
         */
        public function SetupConfig(): \stdClass {
            $file = new File("$this->path/layout.json");
            
            return $file->Json();
        }
    }