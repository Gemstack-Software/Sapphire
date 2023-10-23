<?php
    namespace Sapphire\Styles;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;

    class Style {
        use StyleMinifier;
        use StyleScoper;
        use StyleRenderer;
        use StyleStatic;
        use StyleComponent;

        /**
         * Style file
         */
        private string $file;


        public function __construct(string $file) {
            $this->file = $file;
        }
    }