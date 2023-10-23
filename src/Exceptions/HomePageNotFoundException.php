<?php
    namespace Sapphire\Exceptions;

    use Exception;
    use Sapphire\Error\ErrorHandler;

    class HomePageNotFoundException extends SapphireException {
        public $_message;

        public function __construct($message = null, $code = 0) {
            $this->_message = $message;

            $handler = new ErrorHandler();
            $handler->Exception($this);
        }
    }