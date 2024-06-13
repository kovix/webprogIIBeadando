<?php
namespace ADEJ1R;

class Utility {
    private static $instance = null;

    private function __construct() {}

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone() {
    }

    private function __wakeup() {
    }

    /**
     * @return array Az adatok tárolására szolgáló JSON tömböt olvassa be és adja vissza.
     */
    public function getData()
    {

    }
}