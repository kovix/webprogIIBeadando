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

        $thead = "";
        foreach (LABELS as $label) {
            $thead .= "<th scope=\"col\">{$label}</th>";
        }

        $thead .= "<th>&nbsp;</th>";

        $body = "";
        for($i = 0;$i < count($this->data);$i++) {
            $body .= "
                <tr>
            ";
            foreach ($this->data[$i] as $value) {
                $body .= "<td>{$value}</td>";
            }
            $body .= "
                    <td>
                        <a href=\"#\" class=\"text-primary me-2\">Szerk.</a>
                        <a href=\"index.php?P=delete&idx={$i}\" onclick=\"return confirm('Biztosan törölni szeretné ezt az elemet?');\" class=\"text-danger\">Del.</a>
                    </td>
                </tr>
            ";
        }

        $retval = "
            <div class=\"table-responsive\">
                <table class=\"table table-striped\">
                    <thead>
                        <tr>
                            {$thead}
                        </tr>
                    </thead>
                    <tbody>
                        {$body}
                    </tbody>
                </table> 
            </div>     
        ";

        return $retval;
    }

}