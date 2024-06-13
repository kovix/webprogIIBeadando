<?php

namespace ADEJ1R;

class display {

    private $utility;
    private $data;
    public  function  __construct() {
        $fullClassName = APP_NAMESPACE . "\\Utility";
        $this->utility = $fullClassName::getInstance();
        $this->data  = $this->utility->getData();
    }

    public function  run()
    {
    }

}