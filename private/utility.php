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

    public function __wakeup() {
    }

    /**
     * @return array Az adatok tárolására szolgáló JSON tömböt olvassa be és adja vissza.
     */
    public function getData()
    {
        if (!file_exists(DATA_FILE)) {
            return [];
        }

        $fileContent = file_get_contents(DATA_FILE);
        $data = json_decode($fileContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            die("Az adatfájl nem olvasható be, valószínűleg megsérült. Ellenőrizze a fájl helyességét, vagy törölje");
        }

        return $data;

    }
}