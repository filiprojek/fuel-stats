<?php

class Validator {
    private $errors = [];

    /**
     * Check if a field is not empty
     */
    public function required($field, $value, $message = null) {
        if (empty(trim($value))) {
            $this->errors[$field] = $message ?? "$field is required.";
        }
    }

    /**
     * Check if a field meets minimum length
     */
    public function minLength($field, $value, $length, $message = null) {
        if (strlen($value) < $length) {
            $this->errors[$field] = $message ?? "$field must be at least $length characters.";
        }
    }

    /**
     * Check if a field contains letters and numbers
     */
    public function alphanumeric($field, $value, $message = null) {
        if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d).+$/', $value)) {
            $this->errors[$field] = $message ?? "$field must contain letters and numbers.";
        }
    }

    /**
     * Validate an email
     */
    public function email($field, $value, $message = null) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $message ?? "Invalid email format.";
        }
    }

    /**
     * Get validation errors
     */
    public function errors() {
        return $this->errors;
    }

    /**
     * Check if validation passed
     */
    public function passes() {
        return empty($this->errors);
    }
}
