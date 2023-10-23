<?php
    namespace Sapphire\Minifier;
    
    interface Minifier {
        public static function Minify(string $buffer): string;
    }