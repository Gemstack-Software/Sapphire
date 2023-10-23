<?php
    namespace Sapphire\Styles;

    trait StyleMinifier { 
        /**
         * Minfing css to save space
         */
        public function MinifyCss(string $content): string {
            $content = str_replace("\r\n", " ", $content);
            $content = str_replace("\t", " ", $content);

            while(stristr($content, "  ") !== FALSE) {
                $content = str_replace("  ", " ", $content);
            }

            $content = str_replace(" { ", "{", $content);
            $content = str_replace("; ", ";", $content);
            $content = str_replace(" ;", ";", $content);
            $content = str_replace(": ", ":", $content);
            $content = str_replace(";}", "}", $content);

            return $content;
        }
    }