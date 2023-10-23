<?php
    namespace Onyx\Error\Concerns;

    trait Error {
        public function PreprocessError(string $title): void {
            echo ONYX_PREFIX . " has meet an error during preprocess: $title";
        }

        public function CompilationError(string $title, int $line): void {
            echo ONYX_PREFIX . " has meet an error during preprocess: $title in line: $line";
        }
    }