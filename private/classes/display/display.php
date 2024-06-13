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

        foreach ($this->data as $key => $szindarab) {
            $body .= "
                <tr>
            ";
            foreach ($szindarab as $value) {
                $body .= "<td>{$value}</td>";
            }
            $body .= "
                    <td>
                        <a href=\"#\" class=\"text-primary me-2\">Szerk.</a>
                        <a href=\"index.php?P=delete&idx={$key}\" onclick=\"return confirm('Biztosan törölni szeretné ezt az elemet?');\" class=\"text-danger\">Del.</a>
                    </td>
                </tr>
            ";
        }

        //törlés üzenteinek feldolgozása
        $deleteSuccess = null;
        if (filter_has_var(INPUT_GET, 'deletesuccess')) {
            $deleteSuccess = filter_input(INPUT_GET, 'deletesuccess', FILTER_SANITIZE_NUMBER_INT);
        }

        $deleteMessage = "";

        if ($deleteSuccess === "0") {
            $deleteMessage = $this->utility->gen_alert("danger", "A törlés sikertelen");
        } else {
            $deleteMessage = $this->utility->gen_alert("success", "A törlés sikeres");
        }

        $retval = "
            {$deleteMessage}
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