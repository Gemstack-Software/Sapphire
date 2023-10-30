<?php
    namespace Sapphire\Page;
    use Sapphire\Page\PageStatic;
    use Sapphire\Page\PageSerialize;
    use Sapphire\Page\PageConstruct;
    use Sapphire\Page\PageGetters;
    use Sapphire\Page\PageUrl;
    use Sapphire\Page\PageHome;
    use Sapphire\Page\PageModifiers;
    use Sapphire\Array\Arrayable;

    class Page implements Arrayable {
        use PageStatic;
        use PageSerialize;
        use PageConstruct;
        use PageGetters;
        use PageUrl;
        use PageSaver;
        use PageHome;
        use PageModifiers;
        use PageProperties;

        protected int|null    $id;
        protected int         $parent_id;
        protected string      $name;
        protected string      $subname;
        protected string      $content;
        protected string      $url;
        protected string      $layout;
        protected bool        $is_home;
        protected string      $created_at;
        protected string      $created_by;
        protected string      $updated_at;
        protected string      $updated_by;
    }