<?php
    namespace Sapphire\Json;

    use stdClass;
    use any;

    class Json {
        /**
         * @name Empty
         * @static
         * 
         * Returns an empty json (\stdClass) objcet
         */
        public static function Empty() {
            return static::Make(["" => ""]);
        }

        /**
         * @name Make
         * @static
         * 
         * Makes json object from (e.g. class instance)
         */
        static public function Make($obj): stdClass | bool | array {
            return json_decode(json_encode($obj));
        }

        /**
         * @name FromArray
         * @static
         * 
         * Makes json object from array
         */
        static public function FromArray(array $array): stdClass {
            return static::Make($array);
        }

        /**
         * @name String
         * @static
         * 
         * Makes string out of json (\stdClass)
         */
        static public function String($json): string {
            return json_encode($json);
        }

        /**
         * @name ToArray
         * @static
         * 
         * Makes json to array
         */
        static public function ToArray($obj): array {
            return json_decode(json_encode($obj));
        }
    }