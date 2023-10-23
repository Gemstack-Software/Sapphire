<?php
    namespace Sapphire\Plugin\Helpers;

    use Sapphire\Path\PathConstructor;
    use Sapphire\File\File;
    use Sapphire\Asset\AssetInjector as AssetInjectorFactory;

    trait AssetInjector {
        /**
         * Inject script file and echo it
         */
        public function InjectScript(
            string $path
        ): void {
            AssetInjectorFactory::InjectScript($path);
        }

        /**
         * Inject style file and echo it
         */
        public function InjectStyle(
            string $path
        ): void {
            AssetInjectorFactory::InjectStyle($path);
        }
    }