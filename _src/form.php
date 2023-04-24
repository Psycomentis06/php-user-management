<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/_src/session.php';

function is_form_valid($form_checks_res_array) {
    foreach ($form_checks_res_array as $val) {
        if (!$val['valid']) return false;
    }
    return true;
}


function is_form_submitted() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function render_input($type = 'text', $name = 'input', $label = 'Input', $value = '', $wrapper_class = '', $input_class = '', $saved_values = true) {
    $feedback_html_txt =  '';
    $form_input_class = '';
    if (is_form_submitted()) {
        $flash = flash_session_read($name);
        if (!empty($flash)) {
            $feedback_classname = 'invalid-feedback';
            $form_input_class = 'is-invalid';
            if (isset($flash['valid']) && $flash['valid']) {
                $feedback_classname = 'valid-feedback';
                $form_input_class = 'is-valid';
            }
            $feedback_html_txt = '<div class="' . $feedback_classname . '">' . $flash['message'] . '</div>';
        }
        if ($saved_values) {
            $value = $_POST[$name] ?? '';
        }
    }
    $form_input_class .= ' '. $input_class;
    $input_txt = '
       <div class="form-outline '. $wrapper_class .'">
            <input name="'. $name .'" type="'. $type .'" id="formInput'. $name .'" class="form-control '. $form_input_class.'" value="'. $value .'" />
            <label class="form-label" for="formInput'. $name .'">'. $label .'</label>
            '. $feedback_html_txt .'
        </div>';
    echo $input_txt;
}
