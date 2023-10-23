<?php
    namespace Sapphire\Compilers;

    use Sapphire\Compilers\Compiler;
    use Sapphire\Compilers\Compilable;
    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Onyx\Compiler as OnyxAgent;

    class OnyxCompiler extends Compiler implements Compilable {
        protected $engine;

        /**
         * @name CreateDistFile
         * 
         * Returns empty dist file for .php compiled from .onyx to save
         */
        public function CreateDistFile(string $entry_path): File {
            $path_agent = new PathConstructor("@/resources/~temp/" . hash('sha256', $entry_path) . ".php");
            $file = new File($path_agent->GetReal());

            return $file;
        }

        /**
         * @from Compilable
         */
        public function Compile(File $entry): File {
            $dist = $this->CreateDistFile($entry->GetPath());

            $this->engine ??= new OnyxAgent;
            $this->engine->Run(
                $entry->GetPath(),
                $dist->GetPath()
            );

            return $dist;
        }
    }