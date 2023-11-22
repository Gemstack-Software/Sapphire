<?php
    use Sapphire\Component\Component;
    use Sapphire\Page\Page;
    use Sapphire\Component\Helpers\Translator;
    use Sapphire\Component\Helpers\Styles;

    return (new class extends Component {
        use Translator;
        use Styles;

        public array $tasks = [
            'Clean house',
            'Write cool code',
            'Use sapphire',
            'Eat steaks'
        ];

        ///////////////////////////////////////////////////////////
        // Rendering (.onyx, .php or .html)
        ///////////////////////////////////////////////////////////
        public function View(): string {
            return "test-live.onyx"; // Name of component view
        }
    });