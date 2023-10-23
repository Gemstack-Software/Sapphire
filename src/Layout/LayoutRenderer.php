<?php
    namespace Sapphire\Layout;

    use Sapphire\Layout\Layout;
    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\Exceptions\LayoutNotExistsException;
    use Sapphire\Styles\Style;

    trait LayoutRenderer {
        /**
         * @name RenderHead
         * @static
         * 
         * Renders layout head as HTML using include
         */
        public function RenderHead($data = []): void {
            $path = "$this->path/" . $this->config->entries->head;
            $file = new File($path);

            if($file->IsOnyx())
                $file = Layout::$OnyxCompiler->Compile($file);
             
            $file->Include($data);
        }

        /**
         * @name RenderBody
         * @static
         * 
         * Renders layout body as HTML using include
         */
        public function RenderBody($data = []): void {
            $path = "$this->path/" . $this->config->entries->body;
            $file = new File($path);

            if($file->IsOnyx()) 
                $file = Layout::$OnyxCompiler->Compile($file);
             
            $file->Include($data);
        }
    }