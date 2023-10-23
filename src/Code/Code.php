<?php
    namespace Sapphire\Code;

    class Code {
        /**
         * @name FormatToHTML
         * 
         * Formats code from text to html (example replace \t with 4*&nbsp;)
         */
        public static function FormatToHTML(string $text): string {
            $html = $text;
            
            // Apply rules
            $html = str_replace("    ", "&nbsp;&nbsp;&nbsp;&nbsp;", $html);
            $html = str_replace("  ", "&nbsp;", $html);
            $html = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $html);

            $html = str_replace("<", "&lt;", $html);
            $html = str_replace(">", "&gt;", $html);

            return $html;
        }
    }