<?php
    namespace Sapphire\Collection\Concerns;

    use Sapphire\Farbic\Fabricable;
    use Sapphire\Collection\Concerns\SchemaItem;
    use Sapphire\Collection\Concerns\Schemas\ShortText;
    use Sapphire\Collection\Concerns\Schemas\RichText;
    use Sapphire\Collection\Concerns\Schemas\LongText;
    use Sapphire\Collection\Concerns\Schemas\IntNumber;
    use Sapphire\Collection\Concerns\Schemas\FloatNumber;
    use Sapphire\Collection\Concerns\Schemas\Date;
    use Sapphire\Collection\Concerns\Schemas\Image;
    use Sapphire\Collection\Concerns\Schemas\ImageCollection;
    use Sapphire\Collection\Concerns\Schemas\Video;
    use Sapphire\Collection\Concerns\Schemas\VideoCollection;
    use Sapphire\Collection\Concerns\Schemas\MultimediaCollection;
    use Sapphire\Collection\Concerns\Schemas\MixedArray;

    /**
     * Class to help building schema items
     */
    class SchemaBuilder { //  implements Fabricable
        /**
         * @name Make
         * @static
         * 
         * Makes a SchemaItem by $type if SchemaItem<$type> does not exists returns null 
         */
        public static function Make(string $type): SchemaItem | null {
            return match($type) {
                'ShortText' => new ShortText,
                'RichText' => new RichText,
                'LongText' => new LongText,
                'IntNumber' => new IntNumber,
                'FloatNumber' => new FloatNumber,
                'Date' => new Date,
                'Image' => new Image,
                'ImageCollection' => new ImageCollection,
                'Video' => new Video,
                'VideoCollection' => new VideoCollection,
                'MultimediaCollection' => new MultimediaCollection,
                'MixedArray' => new MixedArray,
                default => null
            };
        }
    }