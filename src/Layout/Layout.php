<?php
    namespace Sapphire\Layout;

    use Sapphire\Layout\LayoutStatic;
    use Sapphire\Layout\LayoutModifiers;
    use Sapphire\Layout\LayoutSetup;
    use Sapphire\Layout\LayoutRenderer;
    use Sapphire\Setup\SetupInterface;

    class Layout implements SetupInterface {
        use LayoutStatic;
        use LayoutModifiers;
        use LayoutSetup;
        use LayoutRenderer;

        protected string $path;
        protected \stdClass $config;

        public static $OnyxCompiler;
    }