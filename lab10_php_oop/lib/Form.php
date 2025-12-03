<?php
/**
 * Class Form
 * Deskripsi: Class untuk membuat form input dengan mudah
 */

class Form {
    private $fields = array();
    private $action;
    private $method = "POST";
    private $submit = "Submit";
    private $enctype = "";

    public function __construct($action, $submit = "Submit", $method = "POST") {
        $this->action = $action;
        $this->submit = $submit;
        $this->method = $method;
    }

    /**
     * Set form untuk upload file
     */
    public function setMultipart($value = true) {
        if ($value) {
            $this->enctype = 'enctype="multipart/form-data"';
        }
    }

    /**
     * Tambah field input text
     */
    public function addInput($name, $label, $type = "text", $value = "", $required = false) {
        $this->fields[] = array(
            'type' => 'input',
            'input_type' => $type,
            'name' => $name,
            'label' => $label,
            'value' => $value,
            'required' => $required
        );
    }

    /**
     * Tambah field textarea
     */
    public function addTextarea($name, $label, $value = "", $required = false) {
        $this->fields[] = array(
            'type' => 'textarea',
            'name' => $name,
            'label' => $label,
            'value' => $value,
            'required' => $required
        );
    }

    /**
     * Tambah field select/dropdown
     */
    public function addSelect($name, $label, $options = array(), $selected = "", $required = false) {
        $this->fields[] = array(
            'type' => 'select',
            'name' => $name,
            'label' => $label,
            'options' => $options,
            'selected' => $selected,
            'required' => $required
        );
    }

    /**
     * Tambah field file upload
     */
    public function addFile($name, $label, $required = false) {
        $this->fields[] = array(
            'type' => 'file',
            'name' => $name,
            'label' => $label,
            'required' => $required
        );
        $this->setMultipart(true);
    }

    /**
     * Tambah field hidden
     */
    public function addHidden($name, $value) {
        $this->fields[] = array(
            'type' => 'hidden',
            'name' => $name,
            'value' => $value
        );
    }

    /**
     * Tampilkan form
     */
    public function displayForm() {
        echo "<form action='" . $this->action . "' method='" . $this->method . "' " . $this->enctype . ">";
        
        foreach ($this->fields as $field) {
            if ($field['type'] == 'hidden') {
                echo "<input type='hidden' name='" . $field['name'] . "' value='" . $field['value'] . "'>";
                continue;
            }

            echo "<div class='input'>";
            echo "<label>" . $field['label'];
            if (isset($field['required']) && $field['required']) {
                echo " <span style='color:red;'>*</span>";
            }
            echo "</label>";

            switch ($field['type']) {
                case 'input':
                    $req = (isset($field['required']) && $field['required']) ? 'required' : '';
                    echo "<input type='" . $field['input_type'] . "' name='" . $field['name'] . "' value='" . $field['value'] . "' " . $req . " />";
                    break;

                case 'textarea':
                    $req = (isset($field['required']) && $field['required']) ? 'required' : '';
                    echo "<textarea name='" . $field['name'] . "' " . $req . ">" . $field['value'] . "</textarea>";
                    break;

                case 'select':
                    $req = (isset($field['required']) && $field['required']) ? 'required' : '';
                    echo "<select name='" . $field['name'] . "' " . $req . ">";
                    foreach ($field['options'] as $value => $text) {
                        $selected = ($value == $field['selected']) ? 'selected' : '';
                        echo "<option value='" . $value . "' " . $selected . ">" . $text . "</option>";
                    }
                    echo "</select>";
                    break;

                case 'file':
                    $req = (isset($field['required']) && $field['required']) ? 'required' : '';
                    echo "<input type='file' name='" . $field['name'] . "' " . $req . " />";
                    break;
            }

            echo "</div>";
        }

        echo "<div class='submit'>";
        echo "<input type='submit' name='submit' value='" . $this->submit . "' />";
        echo "</div>";
        echo "</form>";
    }

    /**
     * Render form dan return sebagai string
     */
    public function render() {
        ob_start();
        $this->displayForm();
        return ob_get_clean();
    }
}
?>