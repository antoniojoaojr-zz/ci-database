<?php

namespace CI;

/**
 * @author Antônio Junior
 */
class DatabaseException extends \Exception {

    private $heading;

    public function __construct($heading, $message) {
        var_dump($message);
        exit;
        parent::__construct($message, 0, null);

        $this->heading = $heading;
    }

    public function getHeading() {
        return $this->heading;
    }

}
