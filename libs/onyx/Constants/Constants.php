<?php
    define("ONYX_PREFIX", "[GemStack/ONYX]");
    define("ONYX_COMMENT_TAG_REGEX", "(--[^-]*--)");
    define("ONYX_CONTENT_TAG_REGEX", "({[^}]*})");
    define("ONYX_METHOD_TAG_REGEX", "(\#{[^}]*})");
    define("ONYX_IF_TAG_REGEX", "(\#if\([^\)]*\))");
    define("ONYX_ELSEIF_TAG_REGEX", "(\#elseif\([^\)]*\))");
    define("ONYX_FOREACH_TAG_REGEX", "(\#foreach\([^\)]*\))");
    define("ONYX_SWITCH_TAG_REGEX", "(\#switch\([^\)]*\))");
    define("ONYX_CASE_TAG_REGEX", "(\#case\([^\)]*\))");
    define("ONYX_FOR_TAG_REGEX", "(\#for\([^\)]*\))");
    define("ONYX_WHILE_TAG_REGEX", "(\#while\([^\)]*\))");
    define("ONYX_COMPONENT_TAG_REGEX", "(\#component\([^\)]*\))");