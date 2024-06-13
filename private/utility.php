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

    private function save_data($data) {
        $json = json_encode($data);
        $result = file_put_contents(DATA_FILE, $json);
        if ($result === false) {
            die("Az adatbázis fájl nem menthető");
        }
    }

    public function insert_data($new) {
        $data = $this->getData();
        $data[] = $new;
        $this->save_data($data);
    }

    public function delete_data($index) {
        $data = $this->getData();

        if (!array_key_exists($index, $data)) {
            return false;
        }

        unset($data[$index]);
        $this->save_data($data);

        return true;
    }

    public function update_data($index, $newData) {
        $data = $this->getData();
        if(!array_key_exists($index, $data)) {
            return false;
        }

        $data[$index] = $newData;

        $this->save_data($data);

        return true;

    }

    public function get_one($index) {
        $data = $this->getData();
        if(!array_key_exists($index, $data)) {
            return false;
        }

        return $data[$index];
    }

    public function get_template_part($name) {
        $path = PRIVATE_DIR . "templates/parts/" . $name . ".html";

        if (!file_exists($path)) {
            die("Salon nem tölthető be: {$path}");
        }

        return file_get_contents($path);

    }

    public function build_mufaj_select($value = "") {
        $hasSelected = false;
        $retval = "";

        if (is_array(MUFAJOK)) {
            foreach (MUFAJOK as $mufaj) {
                $selected = "" ;
                if ($value === $mufaj['value']) {
                    $selected = "selected";
                    $hasSelected = true;
                }
                $retval .= "<option value=\"{$mufaj['value']}\" {$selected}>{$mufaj['label']}</option>";
            }
        }

        $defaultSelected = $hasSelected ? "" : "selected";
        $retval = "<option value=\"\" disabled {$defaultSelected}>Válasszon műfajt</option>" . $retval;

        return $retval;
    }

    public function build_szinpad_select($value = "") {
        $hasSelected = false;
        $retval = "";

        if (is_array(SZINPADOK)) {
            foreach (SZINPADOK as $szinpad) {
                $selected = "" ;
                if ($value === $szinpad['value']) {
                    $selected = "selected";
                    $hasSelected = true;
                }
                $retval .= "<option value=\"{$szinpad['value']}\" {$selected}>{$szinpad['label']}</option>";
            }
        }

        $defaultSelected = $hasSelected ? "" : "selected";
        $retval = "<option value=\"\" disabled {$defaultSelected}>Válasszon színpadot</option>" . $retval;

        return $retval;
    }

    public function gen_alert($type, $message) {
        return "
        <div class=\"alert alert-{$type}\" role=\"alert\">
          {$message}
        </div>
        ";
    }

}