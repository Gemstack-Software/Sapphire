<?php
    namespace Sapphire\Serialize;
    use Sapphire\Json\Json;

    trait Serialize {
        /**
         * Returns ready \stdClass from class instance ready to serialize via File::Json()
         */
        public function Serialize(): \stdClass {
            return Json::Make($this);
        }
    }