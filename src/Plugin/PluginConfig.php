<?php
    namespace Sapphire\Plugin;

    trait PluginConfig {
        /**
         * Contains whole plugin config;
         */
        protected \stdClass $config;

        /**
         * Contains path to plugin's folder
         */
        protected string $path;

        /**
         * Sets the plugin config
         */
        public function SetConfig(\stdClass $config): void {
            $this->config = $config;
        }

        /**
         * Get real config
         */
        public function GetConfig() {
            return $this->config->config;
        }

        /**
         * Get the plugin name
         */
        public function GetName(): string {
            return $this->config->name;
        }

        /**
         * Set path to plugin/s folder
         */
        public function SetPath(string $path): void {
            $this->path = $path;
        }

        /**
         * Get path to plugin's folder
         */
        public function GetPath(): string {
            return $this->path;
        }
    }