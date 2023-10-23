<?php
    use Sapphire\Component\Component;
    use Sapphire\Page\Page;
    use Sapphire\Component\Helpers\Assets;
    use Sapphire\Component\Helpers\Styles;

    return (new class extends Component {
        use Assets;
        use Styles;

        ///////////////////////////////////////////////////////////
        // Rendering (.onyx, .php or .html)
        ///////////////////////////////////////////////////////////
        public function View(): string {
            return "Logo.onyx"; // Name of component view
        }
    });