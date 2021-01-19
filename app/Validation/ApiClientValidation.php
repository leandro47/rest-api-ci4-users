<?php

namespace App\Validation;

use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;

class ApiClientValidation
{
    protected $validations;

    // ==================================================
    // API
    // ==================================================

    public function validateUpdate(IncomingRequest $request, string $cpf): ?array
    {
        $this->validations = array();

        // FirstName 
        if (!isset($request->getJSON()->firstName) || empty($request->getJSON()->firstName)) {
            $this->validations[] = 'Atribute firstName is required';
        }

        // LastName
        if (!isset($request->getJSON()->lastName) || empty($request->getJSON()->lastName)) {
            $this->validations[] = 'Atribute lastName is required';
        }

        // Cpf
        if ($cpf === null) {
            $this->validations[] = 'Atribute cpf is required';
        } else if (!validateCpf($cpf)) {
            $this->validations[] = 'This CPF not is valid';
        }

        // Cep
        if (!isset($request->getJSON()->cep) || empty($request->getJSON()->cep)) {
            $this->validations[] = 'Atribute cep is required';
        } else if (strlen($request->getJSON()->cep) !== 8) {
            $this->validations[] = 'Atribute cep is permitted only 8 digit';
        } else if (!ctype_digit($request->getJSON()->cep)) {
            $this->validations[] = 'Atribute cep is permitted only type integer';
        }

        //Phone
        if (!isset($request->getJSON()->phone) || empty($request->getJSON()->phone)) {
            $this->validations[] = 'Atribute phone is required';
        }

        //email
        if (!isset($request->getJSON()->email) || empty($request->getJSON()->email)) {
            $this->validations[] = 'Atribute email is required';
        }

        if ($this->validations) {
            return  [
                'code'    => Response::HTTP_BAD_REQUEST,
                'message' => implode(" | ", $this->validations),
                'data'    => []
            ];
        }
        return $this->validations;
    }

    public function validateDelete(string $cpf): ?array
    {
        $this->validations = array();

        if ($cpf === null) {
            $this->validations[] = 'Cpf is required';
        } else if (!validateCpf($cpf)) {
            $this->validations[] = 'This CPF not is valid';
        }

        if ($this->validations) {
            return  [
                'code'    => Response::HTTP_BAD_REQUEST,
                'message' => implode(" | ", $this->validations),
                'data'    => []
            ];
        }
        return $this->validations;
    }

    public function validateInsert(IncomingRequest $request): ?array
    {
        $this->validations = array();

        // FirstName 
        if (!isset($request->getJSON()->firstName) || empty($request->getJSON()->firstName)) {
            $this->validations[] = 'Atribute firstName is required';
        }

        // LastName
        if (!isset($request->getJSON()->lastName) || empty($request->getJSON()->lastName)) {
            $this->validations[] = 'Atribute lastName is required';
        }

        // Cpf
        if (!isset($request->getJSON()->cpf) || empty($request->getJSON()->cpf)) {
            $this->validations[] = 'Atribute cpf is required';
        } else if (!validateCpf($request->getJSON()->cpf)) {
            $this->validations[] = 'This CPF not is valid';
        }

        // Cep
        if (!isset($request->getJSON()->cep) || empty($request->getJSON()->cep)) {
            $this->validations[] = 'Atribute cep is required';
        } else if (strlen($request->getJSON()->cep) !== 8) {
            $this->validations[] = 'Atribute cep is permitted only 8 digit';
        } else if (!ctype_digit($request->getJSON()->cep)) {
            $this->validations[] = 'Atribute cep is permitted only type integer';
        }

        //Phone
        if (!isset($request->getJSON()->phone) || empty($request->getJSON()->phone)) {
            $this->validations[] = 'Atribute phone is required';
        }

        //email
        if (!isset($request->getJSON()->email) || empty($request->getJSON()->email)) {
            $this->validations[] = 'Atribute email is required';
        }

        if ($this->validations) {
            return  [
                'code'    => Response::HTTP_BAD_REQUEST,
                'message' => implode(" | ", $this->validations),
                'data'    => []
            ];
        }
        return $this->validations;
    }
}
