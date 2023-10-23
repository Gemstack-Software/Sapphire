<?php
    use Sapphire\Component\Component;
    use Sapphire\Page\Page;
    use Sapphire\Component\Helpers\Translator;
    use Sapphire\Component\Helpers\Styles;

    return (new class extends Component {
        use Translator;
        use Styles;

        ///////////////////////////////////////////////////////////
        // Properties
        ///////////////////////////////////////////////////////////
        public string $user = "";

        ///////////////////////////////////////////////////////////
        // Mounting component event
        ///////////////////////////////////////////////////////////
        public function Mounted(): void {
            $this->user = "John";
        }

        ///////////////////////////////////////////////////////////
        // Rendering (.onyx, .php or .html)
        ///////////////////////////////////////////////////////////
        public function View(): string {
            return ""; // Name of component view
        }
    });