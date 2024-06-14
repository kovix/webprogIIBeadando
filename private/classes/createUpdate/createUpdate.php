<?php

namespace ADEJ1R;

class createUpdate {

    private $utility;
    private $data;

    private $index; //Szerkesztett rekord. NUll ha új
    private $inSave = false;
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

        if (filter_has_var(INPUT_GET, 'idx')) {
            $this->index = filter_input(INPUT_GET, 'idx', FILTER_SANITIZE_NUMBER_INT);
            $value = $this->utility->get_one($this->index);
            if(!$value) {
                die("Érvénytelen index szerkesztéshez");
            }
            $this->currentData = $value;
        }


        if (filter_has_var(INPUT_POST, "action") && $_POST['action'] === "save") {
            $this->inSave = true;
        }

        $this->getPost();
    }

    public function run()
    {

        if (is_null($this->index)) {
            $content = "<h1>Új létrehozás</h1>";
        } else {
            $content = "<h1>Módosítás</h1>";
        }

        $saveSuccess = false;

        if ($this->inSave) {
            $errors = $this->utility->validate_input($this->currentData);
            if ($errors) {
                $content .= $errors;
            } else {
                if (empty($this->index)) {
                    $this->utility->insert_data($this->currentData);
                    $content .=  $this->utility->gen_alert("success", "Sikeres Létrehozás!");
                    $saveSuccess = true;
                } else {
                    $result = $this->utility->update_data($this->index, $this->currentData);
                    if ($result) {
                        $content .=  $this->utility->gen_alert("success", "Sikeres módosítás!");
                        $saveSuccess = true;
                    } else {
                        $content .=  $this->utility->gen_alert("danger", "Az adatok helyesek, de a mentés nem sikerült!");
                        $saveSuccess = false;
                    }
                }

            }
        }


        if (!$saveSuccess) {
            $content .= $this->display_form();
        } else {
            $content .= " <a href=\"" . BASE_URL . "\" class=\"btn btn-secondary\" style=\"margin-top: 20px;\">Vissza a listához</a>";
        }

        return $content;
    }

    private function getPost() {
        foreach ($this->currentData as $key => $value) {
            if (filter_has_var(INPUT_POST, $key)) {
                $value = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                if(!empty($value)) {
                    $this->currentData[$key] = $value;
                }
            }
        }
    }

    private function display_form() {
        $form_content = $this->utility->get_template_part("form");

        $action = BASE_URL;
        if (!is_null($this->index)) {
            $action .= "index.php?idx=" . $this->index;
        }

        $form_content = str_replace("[[action]]", $action, $form_content);
        $form_content = str_replace("[[page]]", "createUpdate", $form_content);

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