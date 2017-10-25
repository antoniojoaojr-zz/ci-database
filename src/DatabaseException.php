<?php

namespace CI;

/**
 * @author Antônio Junior
 */
class DatabaseException extends \Exception {

    private $heading;
    private $message;

    public function __construct($heading, $message) {
        parent::__construct($message);

        $this->heading = $heading;
        $this->message = $message;
    }

    public function getHeading() {
        return $this->heading;
    }

    public function getMessage() {
        return $this->message;
    }

}
