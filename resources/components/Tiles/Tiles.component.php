<?php
    use Sapphire\Component\Component;
    use Sapphire\Page\Page;
    use Sapphire\Collection\Collection;
    use Sapphire\Component\Helpers\Styles;

    return (new class extends Component {
        use Styles;

        public array $tiles = [];
        
        ///////////////////////////////////////////////////////////
        // On mounted event
        ///////////////////////////////////////////////////////////
        public function Mounted(): void {
            // $this->ClientFetch(function() {
                $this->tiles = Collection::Get("HomepageTiles")->All();
                
                // Changes tile into tile->attributes
                foreach($this->tiles as $key => $tile) {
                    $this->tiles[$key] = $tile->attributes;
                }
            // });
        }

        ///////////////////////////////////////////////////////////
        // Rendering (.onyx, .php or .html)
        ///////////////////////////////////////////////////////////
        public function View(): string {
            return "Tiles.onyx"; // Name of component view
        }
    });