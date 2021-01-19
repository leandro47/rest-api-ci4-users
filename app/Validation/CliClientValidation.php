<?php

namespace App\Validation;


class CliClientValidation
{
    protected $validations;

    // ==================================================
    // CLI
    // ==================================================

    public function cpf(string $cpf): ?string
    {
        $this->validations = null;

        if (!validateCpf($cpf)) {
            $this->validations = 'This CPF not is valid.';
        }
        return $this->validations;
    }

    public function cep(string $cep): ?string
    {
        $this->validations = null;

        if (strlen($cep) !== 8) {
            $this->validations = 'CEP is permitted only 8 digit.';
        } else if (!ctype_digit($cep)) {
            $this->validations = 'CEP is permitted only type integer.';
        }

        return $this->validations;
    }
}
