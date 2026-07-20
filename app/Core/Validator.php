<?php

/*
Notice the validator doesn't know anything about:
- Request
- Controller
- Database
- Response

It only knows:
$data
+
rules

This makes it reusable.
You could validate:
Form data
API requests
CSV imports
JSON payloads
using the same class.
*/

declare(strict_types=1);

namespace App\Core;

class Validator
{
    private array $errors = [];

    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];
        
        foreach ($rules as $field => $ruleString) {

            $rulesArray = explode('|', $ruleString);

            foreach ($rulesArray as $rule) {

                $value = $data[$field] ?? null;

                if ($rule === 'required') {

                    if ($value === null || trim((string)$value) === '') {
                        $this->errors[$field][] = "{$field} is required.";
                    }

                } elseif ($rule === 'email') {

                    if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $this->errors[$field][] = "{$field} must be a valid email.";
                    }

                } elseif (str_starts_with($rule, 'min:')) {

                    $min = (int) explode(':', $rule)[1];

                    if (strlen((string)$value) < $min) {
                        $this->errors[$field][] = "{$field} must be at least {$min} characters.";
                    }

                }

            }

        }

        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }
}
            