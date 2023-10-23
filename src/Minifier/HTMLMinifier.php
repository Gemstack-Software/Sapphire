<?php
    namespace Sapphire\Minifier;
    use Sapphire\Minifier\Minifier;

    class HTMLMinifier implements Minifier {
        public static function Minify(string $buffer): string {
            $search = [ '/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s' ];
            $replace = [ '>', '<', '\\1' ];

            if (preg_match("/\<html/i",$buffer) == 1 && preg_match("/\<\/html\>/i",$buffer) == 1) {
                $buffer = preg_replace($search, $replace, $buffer);
            }

            return $buffer;
        }
    }