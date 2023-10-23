<?php
    use Sapphire\Component\Component;
    use Sapphire\Page\Page;
    use Sapphire\Component\Helpers\Styles;

    return (new class extends Component {
        use Styles;

        ///////////////////////////////////////////////////////////
        // Rendering (.onyx, .php or .html)
        ///////////////////////////////////////////////////////////
        public function View(): string {
            return "Tile.onyx"; // Name of component view
        }
    });