<?php
function checkSet(&$value)
{
    if (isset($value))
        return $value;
}
function setValue(&$value)
{
    if (isset($value)) {
        return "value=\"" . $value . "\"";
    } else {
        return '';
    }
}
function setValueAndDisable(&$value)
{
    if (isset($value)) {
        return "value=\"$value\"" . "disabled";
    } else {
        return '';
    }
}
function setValueAndCheck(&$value)
{
    if (isset($value)) {
        return "value=\"$value\"" . "disabled checked";
    } else {
        return '';
    }
}
function setCheckbox(&$value)
{
    if (isset($value)) {
        return "disabled checked";
    }
}

/**
 * Create an input field HTML element.
 * 
 * @param {string} $name - The name attribute of the input field.
 * @param {string} $id - The id attribute of the input field.
 * @param {string} $type - The type attribute of the input field.
 * @param {string} $label - The label text for the input field.
 * @param {string} $value - The initial value of the input field (optional).
 * @param {string} $required - The required attribute of the input field (optional).
 * @returns {string} - The HTML markup for the input field.
 */
function createInputField($name, $id, $type, $label, $value = '', $required = '')
{
    return '<div class="input_box">
                <input type="' . $type . '" autocomplete="off" id="' . $id . '" placeholder=" " name="' . $name . '"' . $value . ' class="input" ' . $required . '>
                <label class="label" for="' . $name . '" class="test">' . $label . '</label>
            </div>';
}
