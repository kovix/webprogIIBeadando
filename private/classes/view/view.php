<?php

namespace ADEJ1R;

class view {

    private $utility;
    private $index;
    private $currentData;
    public  function  __construct() {
        $fullClassName = APP_NAMESPACE . "\\Utility";
        $this->utility = $fullClassName::getInstance();

        if (filter_has_var(INPUT_GET, 'idx')) {
            $this->index = filter_input(INPUT_GET, 'idx', FILTER_SANITIZE_NUMBER_INT);
            $value = $this->utility->get_one($this->index);
            if(!$value) {
                die("Érvénytelen Nincs ilyen rekord");
            }
            $this->currentData = $value;
        }

    }

    public function  run()
    {

        $retval = "
            <div class=\"card\">
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">Színdarab Adatok</h5>
                        <p class=\"card-text\"><strong>Író:</strong> {$this->currentData['iro']}</p>
                        <p class=\"card-text\"><strong>Színdarab:</strong> {$this->currentData['szindarab']}</p>
                        <p class=\"card-text\"><strong>Rendező:</strong> {$this->currentData['rendezo']}</p>
                        <p class=\"card-text\"><strong>Műfaj:</strong> {$this->currentData['mufaj']}</p>
                        <p class=\"card-text\"><strong>Színpad:</strong> {$this->currentData['szinpad']}</p>
                    </div>
                    <div class=\"card-footer\">
                        <a href=\"" . BASE_URL . "\" class=\"btn btn-primary\">Vissza</a>
                    </div>
            </div>        
        ";

        return $retval;

    }

}