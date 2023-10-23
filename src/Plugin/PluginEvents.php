<?php
    namespace Sapphire\Plugin;

    trait PluginEvents {
        /**
         * This array contains all event handlers
         */
        public array $event_handlers = [];
        
        /**
         * Register all events
         */
        public function RegisterEvents(array $events): void {
            foreach($events as $name => $handler) {
                $this->RegisterEvent($name, $handler);
            }
        }

        /**
         * Register single event
         */
        public function RegisterEvent(string $name, $handler): void {
            $this->event_handlers[$name] = $handler;
        }

        /**
         * Fire event
         */
        public function FireEvent(string $event_name): void {
            if(@$event = $this->event_handlers[$event_name]) {
                if(!$event) return;

                $event($this);
            }
        }  
    }