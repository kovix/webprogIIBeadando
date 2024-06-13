<?php

namespace ADEJ1R;

class create {

    private $utility;
    private $data;
    private $currentData = [
        "iro" => "",
        "szindarab" => "",
        "rendezo" => "",
        "mufaj" => "",
        "szinpad" => "",
    ];
    public  function  __construct() {
        $fullClassName = APP_NAMESPACE . "\\Utility";
        $this->utility = $fullClassName::getInstance();
        $this->getPost();
        //$this->data  = $this->utility->getData();
    }

    public function  run()
    {

        $content = "<h1>Új létrehozás</h1>";

        $saveSuccess = false;

        if (filter_has_var(INPUT_POST, "action") && $_POST['action'] === "save") {
            $errors = $this->validate_input();
            if ($errors) {
                $content .= $errors;
            } else {
                $this->utility->insert_data($this->currentData);
                $content .=  $this->utility->gen_alert("success", "Sikeres mentés!");
                $saveSuccess = true;
            }
        }


        if (!$saveSuccess) {
            $content .= $this->display_form();
        } else {
            $content .= " <a href=\"" . BASE_URL . "\" class=\"btn btn-secondary\" style=\"margin-top: 20px;\">Vissza a listához</a>";
        }

        return $content;
    }

    private function validate_input() {
        //Minden mező kötelező
        $errors = "";
        foreach ($this->currentData as $key => $value) {
            if (empty($value)) {
                $errors .= $this->utility->gen_alert("danger", "A(z) " . LABELS[$key] . " mező kitöltése kötelező!");
            }
        }
        return $errors;
    }

    private function getPost() {
        foreach ($this->currentData as $key => $value) {
            if (filter_has_var(INPUT_POST, $key)) {
                $this->currentData[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
    }

    private function display_form() {
        $form_content = $this->utility->get_template_part("form");

        $form_content = str_replace("[[action]]", BASE_URL, $form_content);
        $form_content = str_replace("[[page]]", "create", $form_content);

        $form_content = str_replace("[[mufaj]]", $this->utility->build_mufaj_select($this->currentData['mufaj']), $form_content);
        $form_content = str_replace("[[szinpad]]", $this->utility->build_szinpad_select($this->currentData['szinpad']), $form_content);

        foreach($this->currentData as $key => $value) {
            if ($key === "mufaj" || $key === "szinpad") {
                continue;
            }
            $form_content = str_replace("[[{$key}]]", $value, $form_content);
        }

        return $form_content;

    }

}