<?php
    namespace Onyx;

    use Onyx\CompilerInterface;
    use Onyx\Compiler\Concerns\Lines;
    use Onyx\Compiler\Concerns\Buffer;
    use Onyx\ValidInterface;
    use Onyx\Valid\Concerns\Valid;
    use Onyx\ErrorInterface;
    use Onyx\Error\Concerns\Error;
    use Onyx\ExpressionableInterface;
    use Onyx\Expressionable\Concerns\Expressionable;
    use Sapphire\Settings\SettingsManager;

    class Compiler implements 
        CompilerInterface, 
        ValidInterface,
        ErrorInterface,
        ExpressionableInterface {

        use Lines;
        use Buffer;
        use Expressionable;
        use Error;
        use Valid;
        
        /**
         * @name source_buffer
         * @type {string}
         * 
         * Contains layout source buffer (file content)
         */
        private string $source_buffer;
        
        public function Run(string $source_file, string $dist_file): void {
            if(!$this->Valid($source_file)) {
                $this->PreprocessError("File $source_file is not valid layout file!");
                return;
            }

            // Read file contents
            $this->source_buffer = $this->ReadSourceBuffer($source_file);

            // Generates lines from buffer
            $lines = $this->BufferToLines($this->source_buffer);

            // Generating dist buffer
            $dist_buffer = $this->TransformLines($lines);

            // Minify the dist buffer
            $dist_buffer = $this->Minify($dist_buffer);

            // Save changes
            file_put_contents($dist_file, $dist_buffer);
        }

        /**
         * @name Minify
         * @type {string}
         * 
         * Minifies string buffer but not completly
         */
        public function Minify(string $buffer): string {
            // Deleting double EOL
            while(stristr($buffer, "\r\n\r\n") !== FALSE)
                $buffer = str_replace("\r\n\r\n", "\r\n", $buffer);

            // Remove all whitespaces that are not in quotes and are longer than 2 in a row
            while(stristr($buffer, "  ") !== FALSE)
                $buffer = preg_replace('/( ){2,}(?=([^"]*"[^"]*")*[^"]*$)/', " ", $buffer); // FIXME

            // Deleting empty lines
            $lines = $this->BufferToLines($buffer);

            foreach($lines as $key => $line) {
                if(str_replace(" ", "", $line) === "") array_splice($lines, $key, 1);
            }

            // Returning buffer
            return implode(SettingsManager::GetSetting("Production", "Minify compiled resources") ? "" : "\r\n", $lines);
        }
    }