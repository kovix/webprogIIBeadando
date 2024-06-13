<?php

namespace ADEJ1R;

class delete {

    private $utility;
    private $data;
    public  function  __construct() {
        $fullClassName = APP_NAMESPACE . "\\Utility";
        $this->utility = $fullClassName::getInstance();
        $this->data  = $this->utility->getData();
    }

    public function  run()
    {
        $index = null;
        if (filter_has_var(INPUT_GET, 'idx')) {
            $index = filter_input(INPUT_GET, 'idx', FILTER_SANITIZE_NUMBER_INT);
        }

        if (!is_numeric($index)) {
            header("Location: " . BASE_URL . "/index.php?deletesuccess=0");
            exit();
        }

        //szám, megpróbáljuk törölni
        $result = $this->utility->delete_data($index);

        $urlPart = $result ? 1 : 0;
        header("Location: " . BASE_URL . "/index.php?deletesuccess={$urlPart}");
        exit();
    }

}