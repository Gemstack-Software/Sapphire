<?php
    namespace Sapphire\Analytics\Handlers;

    use Sapphire\Request\Request;
    use Sapphire\API\API;
    use Sapphire\Json\Json;

    define("ANALYTICS_SECOND", 1000);
    define("ANALYTICS_MINUTE", ANALYTICS_SECOND * 60);
    define("ANALYTICS_HOUR", ANALYTICS_MINUTE * 60);
    define("ANALYTICS_DAY", ANALYTICS_HOUR * 24);
    define("ANALYTICS_WEEK", ANALYTICS_DAY * 7);
    define("ANALYTICS_MONTH", ANALYTICS_DAY * 30.41);
    define("ANALYTICS_YEAR", ANALYTICS_DAY * 365.25);
    

    trait Analytics {
        public function InitAnalytics() {
            //////////////////////////////////////////
            // Check if request is API
            //////////////////////////////////////////
            if(API::Request()) return;
            $request = new Request;

            //////////////////////////////////////////
            // Getting the request path
            //////////////////////////////////////////
            $path = $request->GetUrlPath();

            //////////////////////////////////////////
            // Is admin panel
            //////////////////////////////////////////
            if(stristr($path, "/admin") !== FALSE) return;

            //////////////////////////////////////////
            // Getting the time start
            //////////////////////////////////////////
            $time = microtime(true) * 10000;

            //////////////////////////////////////////
            // Getting the client ip
            //////////////////////////////////////////
            $client = $request->GetIP();

            //////////////////////////////////////////
            // Save record in table
            //////////////////////////////////////////
            $this->table->Insert([
                NULL,
                $time,
                $path,
                $client
            ]);
        }

        /**
         * Returns how many views has 
         */
        public function GetViews(int $period = ANALYTICS_DAY, int $offset = 0): int {
            //////////////////////////////////////////
            // Get current time
            //////////////////////////////////////////
            $current_time = microtime(true) * 1000;

            //////////////////////////////////////////
            // Fetch views in last $period ms time
            //////////////////////////////////////////
            $views = $this->table->AllWhere([
                ['time_start', '>', $current_time - $offset - $period],
                ['time_start', '<', $current_time - $offset]
            ]);

            //////////////////////////////////////////
            // Return count of views
            //////////////////////////////////////////
            return count($views);
        }

        /**
         * Returns how many new visitors visited website
         */
        public function GetNewVisitors(int $period = ANALYTICS_DAY, int $offset = 0): int {
            ////////////////////////////////////////////////////////////////////////////////////
            // Get current time
            ////////////////////////////////////////////////////////////////////////////////////
            $current_time = microtime(true) * 1000;

            ////////////////////////////////////////////////////////////////////////////////////
            // Fetch views in last $period ms time and non period
            ////////////////////////////////////////////////////////////////////////////////////
            $period_views = $this->table->AllWhere([
                ['time_start', '>', $current_time - $offset - $period],
                ['time_start', '<', $current_time - $offset]
            ]);

            $non_period_views = $this->table->AllWhere([
                ['time_start', '<', $current_time - $offset - $period],
                ['time_start', '<', $current_time - $offset]
            ]);

            ////////////////////////////////////////////////////////////////////////////////////
            // Get unique views in period
            ////////////////////////////////////////////////////////////////////////////////////
            $unique = [];
            foreach($period_views as $view) {
                foreach($unique as $item) {
                    if($item->client === $view->client) continue(2);
                }

                $unique[] = $view;
            }

            ////////////////////////////////////////////////////////////////////////////////////
            // Check if any from unique was before the period
            ////////////////////////////////////////////////////////////////////////////////////
            foreach($unique as $key => $item) {
                foreach($non_period_views as $view) {
                    if($item->client === $view->client) array_splice($unique, $key, 1);
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////
            // Return count of unique views
            ////////////////////////////////////////////////////////////////////////////////////
            return count($unique);
        }

        /**
         * Returns how many visitors visited website (not unique visitors)
         */
        public function GetVisitors(int $period = ANALYTICS_DAY, int $offset = 0): int {
            ////////////////////////////////////////////////////////////////////////////////////
            // Get current time
            ////////////////////////////////////////////////////////////////////////////////////
            $current_time = microtime(true) * 1000;

            ////////////////////////////////////////////////////////////////////////////////////
            // Fetch views in last $period ms time and non period
            ////////////////////////////////////////////////////////////////////////////////////
            $period_views = $this->table->AllWhere([
                ['time_start', '>', $current_time - $offset - $period],
                ['time_start', '<', $current_time - $offset]
            ]);

            ////////////////////////////////////////////////////////////////////////////////////
            // Get unique views in period
            ////////////////////////////////////////////////////////////////////////////////////
            $unique = [];
            foreach($period_views as $view) {
                foreach($unique as $item) {
                    if($item->client === $view->client) continue(2);
                }

                $unique[] = $view;
            }

            ////////////////////////////////////////////////////////////////////////////////////
            // Return count of unique views
            ////////////////////////////////////////////////////////////////////////////////////
            return count($unique);
        }

        /**
         * Return array of views in month
         */
        public function GetMonthViewsArray(): array {
            $array = [];

            ////////////////////////////////////////////////////////////////////////////////////
            // 30 times fetch daily views and push it to array
            ////////////////////////////////////////////////////////////////////////////////////
            for($i = 0; $i < 30; $i++) 
                $array[] = $this->GetViews(ANALYTICS_DAY, $i * ANALYTICS_DAY);

            ////////////////////////////////////////////////////////////////////////////////////
            // Reverse array
            ////////////////////////////////////////////////////////////////////////////////////
            $array = array_reverse($array);

            ////////////////////////////////////////////////////////////////////////////////////
            // Return array of views in month day by day
            ////////////////////////////////////////////////////////////////////////////////////
            return $array;
        }

        /**
         * Return array of new visitors in month
         */
        public function GetMonthNewVisitorsArray(): array {
            $array = [];

            ////////////////////////////////////////////////////////////////////////////////////
            // 30 times fetch daily views and push it to array
            ////////////////////////////////////////////////////////////////////////////////////
            for($i = 0; $i < 30; $i++) 
                $array[] = $this->GetNewVisitors(ANALYTICS_DAY, $i * ANALYTICS_DAY);

            ////////////////////////////////////////////////////////////////////////////////////
            // Reverse array
            ////////////////////////////////////////////////////////////////////////////////////
            $array = array_reverse($array);

            ////////////////////////////////////////////////////////////////////////////////////
            // Return array of views in month day by day
            ////////////////////////////////////////////////////////////////////////////////////
            return $array;
        }

        /**
         * Return array of visitors in month
         */
        public function GetMonthVisitorsArray(): array {
            $array = [];

            ////////////////////////////////////////////////////////////////////////////////////
            // 30 times fetch daily views and push it to array
            ////////////////////////////////////////////////////////////////////////////////////
            for($i = 0; $i < 30; $i++) 
                $array[] = $this->GetVisitors(ANALYTICS_DAY, $i * ANALYTICS_DAY);

            ////////////////////////////////////////////////////////////////////////////////////
            // Reverse array
            ////////////////////////////////////////////////////////////////////////////////////
            $array = array_reverse($array);

            ////////////////////////////////////////////////////////////////////////////////////
            // Return array of views in month day by day
            ////////////////////////////////////////////////////////////////////////////////////
            return $array;
        }
    }