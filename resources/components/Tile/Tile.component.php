<?php
    use Sapphire\Component\Component;
    use Sapphire\Page\Page;
    use Sapphire\Component\Helpers\Styles;

    return (new class extends Component {
        use Styles;

        public bool $visible;

        public function Mounted(): void {
            $this->visible = true;
        }

        ///////////////////////////////////////////////////////////
        // Rendering (.onyx, .php or .html)
        ///////////////////////////////////////////////////////////
        public function View(): string {
            return "Tile.onyx"; // Name of component view
        }
    });